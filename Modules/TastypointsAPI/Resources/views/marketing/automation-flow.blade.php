@extends('tastypointsapi::marketing.partials.master')
@section( 'page_name', "Marketing Campagins - Automation flow list")

@section('page_css')
<meta name="session_id" content="{{ Request::get("session")->session_id }}">

  <link href="/tasty/vendor/Drawflowy-main/jsoneditor/dist/jsoneditor.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Inconsolata%7CUbuntu+Mono%7CSlabo+27px%7CRoboto+Slab&amp;subset=latin,latin,latin,latin"
    media="all" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jerosoler/Drawflow/dist/drawflow.min.css" />
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
  {{-- <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" /> --}}
  {{-- <link rel="stylesheet" type="text/css" href="/tasty/vendor/Drawflowy-main/beautiful.css" /> --}}
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/tasty/vendor/Drawflowy-main/my.css" />
  <style>
    .blockyright {
        margin-right: 15px;
        margin-top: -5px;
    }
    .condition .output_1::after, .condition .output_2::after {
      width: 30px;
      height: 30px;
      font-size: 10pt;
    }
  </style>
@endsection

@section('content-header',"Funnel Automation")

@section('main_content')
  <div class="col-md-12">
    <div class="box box-primary">
        <div class="box-body" style="padding: 0px;height:200vh;">
            <div id="navigation">
              <div id="leftside">
                <div id="details">
                  <div id="back">
                    <img src="/assets/arrow.svg" />
                  </div>
                  <div id="names">
                    <div>
                      <p class="title flowName">Your automation pipeline</p>
                      <!-- <img class="edit-title edit-content" src="assets/edit-icon.svg" alt="" /> -->
                    </div>
                    <div>
                      <p class="subtitle flowDescription">Marketing automation</p>
                      <!-- <img class="edit-subtitle edit-content" src="assets/edit-icon.svg" alt="" /> -->
                    </div>
                    <div style="display: none;">
                      <p class="maxRunTimes">0</p>
                    </div>
                    <div style="display: none;">
                      <p class="user_run_limit_seconds">0</p>
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn-story"><img src="/assets/quill.svg" alt="" />Story</button>
          
          
          
          
              <div id="centerswitch">
                <button id="leftswitch">Diagram view</button>
                <button id="rightswitch">Code editor</button>
                <button id="active">
                  <span>Active</span>
                  <label class="switch">
                    <input type="checkbox" />
                    <span class="slider"></span>
                  </label>
                </button>
                <button class="flowSettings">
                  <img src="/assets/flowsettings.png" alt="">
                </button>
              </div>
              <button id="discard">Delete flow</button>
              <button id="publish" disabled>Save flow</button>
              <div id="opencard">
                <img src="/assets/right-arrow.svg" />
              </div>
            </div>
            <main>
              <section id="leftcard">
          
                <div id="search">
                  <img src="/assets/search.svg" />
                  <input type="text" placeholder="Search blocks" />
                  <div id="closecard">
                    <img src="/assets/left-arrow.svg" />
                  </div>
                </div>
                <div id="categories">
                  <div id="subnav">
                  </div>
                </div>
                <div id="blocklist">
          
                </div>
                <div id="add-block" class="blockelem">
                  <div class="blockyright">
                    <img src="/tasty/images/more.svg">
                  </div>
                  <img class="plus" src="/assets/plus.svg" alt="">
                </div>
              </section>
              <div class="col-right" id="my-draw">
                <div class="menu">
                  <div data-version="Home" class="selected">
                    Prototyping<span>:0</span>
                  </div>
                  <ul>
          
                  </ul>
                </div>
                <div id="drawflow">
                  <div class="blur"></div>
                  <button class="btn-clear noselect" onclick="editor.clearModuleSelected()">
                    Clear
                  </button>
                  <button class="btn-commit noselect">Commit</button>
                  <div class="btn-lock">
                    <i id="lock" class="fas fa-lock-open" onclick="editor.editor_mode='fixed'; changeMode('lock');"></i>
                    <i id="unlock" class="fas fa-lock" onclick="editor.editor_mode='edit'; changeMode('unlock');"
                      style="display: none"></i>
                  </div>
                  <div class="bar-zoom">
                    <i class="fas fa-search-minus" onclick="editor.zoom_out()"></i>
                    <i class="fas fa-search" onclick="editor.zoom_reset()"></i>
                    <i class="fas fa-search-plus" onclick="editor.zoom_in()"></i>
                  </div>
                </div>
              </div>
              <div class="col-right" id="jsoneditor"></div>
              <section class="col-right" id="node-settings">
          
                <div class="left">
          
                </div>
          
          
                <div class="jsoneditor"></div>
          
              </section>
              <section id="groups-settings">
                <h1>Node groups</h1>
                <div class="items">
          
                </div>
                <div class="buttons">
                  <button class="delete-category save">Save</button>
                  <button class="delete-category add-category">Add new</button>
                </div>
                <div class="side-elem-more close">
                  <img src="/assets/close.svg" alt="">
                </div>
          
              </section>
          
              <section id="flowSettings">
                <button class="close">
                  <img src="/assets/close.svg" alt="">
                </button>
                <label>
                  Flow name:
                  <input class="flowName" type="text">
                </label>
                <label>
                  Flow description:
                  <input class="flowDescription" type="text">
                </label>
                <label>
                  Max run times:
                  <input class="maxRunTimes" type="number">
                </label>
                <label>
                  User run limit seconds:
                  <input class="user_run_limit_seconds" type="number">
                </label>
          
                <div class="backgroundSettings">
                  <label>
                    Opacity:
                    <input class="backgroundOpacity" type="range" min="0" max="100">
                  </label>
                  <label>
                    Blur:
                    <input class="backgroundBlur" type="range" min="0" max="100">
                  </label>
          
                  <div class="backgroundImages">
          
                  </div>
                </div>
              </section>
          
              <section class="col-right" id="nodeTemplate">
                <header>
                  Node template
                </header>
                <div class="jsoneditor">
          
                </div>
              </section>
          
              <div id="flowStory" class="quill-editor col-right" data-quill-editor="${moduleName}">
                <div class="editor"></div>
              </div>
          
            </main>
          
            <template id="group-template">
              <div id="category-${id}" class="category navdisabled side">
                ${node_group_name}
              </div>
            </template>
          
            <template id="sideElem">
              <div class="blockelem create-flowy noselect">
                <div class="grabme">
                  <img src="/assets/grabme.svg" />
                </div>
                <div class="blockin">
                  <div class="blockico">
                    <span></span>
                    <img src="/assets/eye.svg" />
                  </div>
                  <div class="blocktext">
                    <!-- <div class="side-elem-title"> -->
                    <p class="blocktitle noselect">${title}</p>
                    <div class="side-elem-more">
                      <img src="/tasty/images/more.svg">
                    </div>
                    <!-- </div> -->
                    <p class="blockdesc noselect">${desc}</p>
                  </div>
          
                </div>
              </div>
            </template>
            <template id="quill-template">
              <div class="quill-editor col-right" data-quill-editor="${moduleName}">
                <div class="editor"></div>
              </div>
            </template>
          
            <template id="categories-ettings-template">
              <div class="categories-ettings-template" style="order: -2; width: calc(88% / 3);">
                <img id="categories-settings" class="plus" src="/assets/settings.svg" alt="">
                <style>
                  .categories-ettings-template {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto;
                    font-family: Roboto;
                    color: #808292;
                    font-size: 14px;
                    height: 48px;
                    width: calc(88% / 3);
                    text-align: center;
                    position: relative;
                  }
                </style>
              </div>
            </template>
        </div>
    </div>
  </div>
@stop



@section('javascript')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

</script>
<script src="/tasty/vendor/Drawflowy-main/jsoneditor/dist/jsoneditor.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js" type="text/javascript" async></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/jerosoler/Drawflow/dist/drawflow.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>

{{-- <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script> --}}

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script src="/tasty/vendor/Drawflowy-main/binaryFlow.js"></script>
<script defer src="/tasty/vendor/Drawflowy-main/main.js"></script>
<script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
@endsection
