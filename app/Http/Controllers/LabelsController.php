<?php

namespace App\Http\Controllers;

use App\Barcode;
use App\Product;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabelsController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $transactionUtil;
    protected $productUtil;

    /**
     * Constructor
     *
     * @param TransactionUtil $TransactionUtil
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, ProductUtil $productUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->productUtil = $productUtil;
    }

    /**
     * Display labels
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');
        $purchase_id = $request->get('purchase_id', false);
        $product_id = $request->get('product_id', false);

        //Get products for the business
        $products = [];
        if ($purchase_id) {
            $products = $this->transactionUtil->getPurchaseProducts($business_id, $purchase_id);
        } elseif ($product_id) {
            $products = $this->productUtil->getDetailsFromProduct($business_id, $product_id);
        }

        $barcode_settings = Barcode::where('business_id', $business_id)
                                ->orWhereNull('business_id')
                                ->select(DB::raw('CONCAT(name, ", ", description) as name, id'))
                                ->pluck('name', 'id');

        return view('labels.show')
            ->with(compact('products', 'barcode_settings'));
    }

    /**
     * Returns the html for product row
     *
     * @return \Illuminate\Http\Response
     */
    public function addProductRow(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->input('product_id');
            $variation_id = $request->input('variation_id');
            $business_id = $request->session()->get('user.business_id');
            
            if (!empty($product_id)) {
                $index = $request->input('row_count');
                $products = $this->productUtil->getDetailsFromProduct($business_id, $product_id, $variation_id);
                
                return view('labels.partials.show_table_rows')
                        ->with(compact('products', 'index'));
            }
        }
    }

    /**
     * Returns the html for labels preview
     *
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        try {
            $products = $request->get('products');
            // $barcode_show = $request->get('barcode_show');
            $show_all = $request->get('show_all');
            $print = $request->get('print');
            $barcode_setting = $request->get('barcode_setting');
            $business_id = $request->session()->get('user.business_id');

            $barcode_show = isset($print["barcode_show"]);

            if(intval($show_all) === 1){
                $produk = \App\Product::where(["business_id"=>$business_id])
                ->with("variations")
                ->get();
                $products = [];
                foreach ($produk as $key => $value) {
                    $products[] = [
                        "product_id" => $value->id,
                        "variation_id" => $value->variations->first()->id,
                        "quantity" => 1
                    ];
                }
            }

            $barcode_details = Barcode::find($barcode_setting);

            // $barcode_details->stickers_in_one_sheet = $barcode_details->is_continuous ? $barcode_details->stickers_in_one_row : $barcode_details->stickers_in_one_sheet;
            $barcode_details->stickers_in_one_sheet = 20;

            $barcode_details->paper_height = $barcode_details->is_continuous ? $barcode_details->height : $barcode_details->paper_height;

            if($barcode_details->stickers_in_one_row == 1){
                $barcode_details->col_distance = 0;
                $barcode_details->row_distance = 0;
            }
            if($barcode_details->is_continuous){
                $barcode_details->row_distance = 0;
            }

            $business_name = $request->session()->get('business.name');

            $product_details_page_wise = [];
            $total_qty = 0;

            foreach ($products as $value) {
                $details = $this->productUtil->getDetailsFromVariation($value['variation_id'], $business_id, null, false);

                for ($i=0; $i < $value['quantity']; $i++) {

                    $page = intdiv($total_qty, $barcode_details->stickers_in_one_sheet);

                    if($total_qty % $barcode_details->stickers_in_one_sheet == 0){
                        $product_details_page_wise[$page] = [];
                    }

                    $product_details_page_wise[$page][] = $details;
                    $total_qty++;
                }
            }

            $margin_top = $barcode_details->is_continuous ? 0: $barcode_details->top_margin*1;
            $margin_left = $barcode_details->is_continuous ? 0: $barcode_details->left_margin*1;
            $paper_width = $barcode_details->paper_width*1;
            $paper_height = $barcode_details->paper_height*1;

            // print_r($paper_height);
            // echo "==";
            // print_r($margin_left);exit;

            // $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 
            //             'format' => [$paper_width, $paper_height],
            //             'margin_top' => $margin_top,
            //             'margin_bottom' => $margin_top,
            //             'margin_left' => $margin_left,
            //             'margin_right' => $margin_left,
            //             'autoScriptToLang' => true,
            //             // 'disablePrintCSS' => true,
            // 'autoLangToFont' => true,
            // 'autoVietnamese' => true,
            // 'autoArabic' => true
            //             ]
            //         );
            //print_r($mpdf);exit;

            $i = 0;
            $len = count($product_details_page_wise);
            $is_first = false;
            $is_last = false;

            //$original_aspect_ratio = 4;//(w/h)
            $factor = (($barcode_details->width / $barcode_details->height)) / ($barcode_details->is_continuous ? 2 : 4);
            $html = '';
            foreach ($product_details_page_wise as $page => $page_products) {

                if($i == 0){
                    $is_first = true;
                }

                if($i == $len-1){
                    $is_last = true;
                }

                $output = view('labels.partials.preview_2')
                ->with(
                    compact(
                        'print', 
                        'page_products', 
                        'business_name', 
                        'barcode_details', 
                        'margin_top', 
                        'margin_left', 
                        'paper_width', 
                        'paper_height', 
                        'is_first', 
                        'is_last', 
                        'factor',
                        'barcode_show'
                        )
                )->render();
                print_r($output);
                //$mpdf->WriteHTML($output);

                // if($i < $len - 1){
                //     // '', '', '', '', '', '', $margin_left, $margin_left, $margin_top, $margin_top, '', '', '', '', '', '', 0, 0, 0, 0, '', [$barcode_details->paper_width*1, $barcode_details->paper_height*1]
                //     $mpdf->AddPage();
                // }

                $i++;
            }

            print_r('<script>window.print()</script>');
            exit;
            //return $output;

            //$mpdf->Output();

            // $page_height = null;
            // if ($barcode_details->is_continuous) {
            //     $rows = ceil($total_qty/$barcode_details->stickers_in_one_row) + 0.4;
            //     $barcode_details->paper_height = $barcode_details->top_margin + ($rows*$barcode_details->height) + ($rows*$barcode_details->row_distance);
            // }

            // $output = view('labels.partials.preview')
            //     ->with(compact('print', 'product_details', 'business_name', 'barcode_details', 'product_details_page_wise'))->render();

            // $output = ['html' => $html,
            //                 'success' => true,
            //                 'msg' => ''
            //             ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = __('lang_v1.barcode_label_error');
        }

        //return $output;
    }
}
