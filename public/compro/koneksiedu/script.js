const baseURL = "";

const linkBerkasPPDB = {
  link_pembayaran_ppdb: "",
  link_kartu_keluarga: "",
  link_akta_lahir: "",
  pas_foto: "",
};

document.addEventListener("DOMContentLoaded", () => {
  const burgerMenu = document.getElementById("burgerMenu");
  const mobileMenu = document.getElementById("mobileMenu");
  const jenisPendaftaranInput = document.getElementById("jenis-pendaftaran");
  const namaAsalSekolahInput = document.getElementById(
    "input-nama-asal-sekolah"
  );
  const npsnAsalSekolahInput = document.getElementById(
    "input-npsn-asal-sekolah"
  );
  const nisnInput = document.getElementById("input-nisn");
  const namaAsalSekolahInputText = document.getElementById("nama-asal-sekolah");
  const npsnAsalSekolahInputText = document.getElementById("npsn-asal-sekolah");
  const nisnInputText = document.getElementById("nisn");

  burgerMenu.addEventListener("click", () => {
    mobileMenu.style.maxHeight =
      mobileMenu.style.maxHeight === "0px" || !mobileMenu.style.maxHeight
        ? "400px"
        : "0px";
  });

  jenisPendaftaranInput.addEventListener("change", () => {
    const isSiswaBaru = jenisPendaftaranInput.value === "siswa-baru";
    namaAsalSekolahInput.classList.toggle("invisible", isSiswaBaru);
    npsnAsalSekolahInput.classList.toggle("invisible", isSiswaBaru);
    nisnInput.classList.toggle("invisible", isSiswaBaru);

    namaAsalSekolahInputText.required = !isSiswaBaru;
    npsnAsalSekolahInputText.required = !isSiswaBaru;
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
      mobileMenu.style.maxHeight = "0px"; // Hide mobile menu
    }
  });
});

async function submitPPDB(event) {
  event.preventDefault();

  const submitButton = document.getElementById("button-submit");

  submitButton.setAttribute("disabled", "");
  submitButton.classList.add("bg-gray-300");
  submitButton.classList.remove("bg-[#286D6B]");
  submitButton.classList.add("cursor-not-allowed");
  submitButton.textContent = "Mengirim...";

  const form = event.target;

  if (form.checkValidity()) {
    const jenisPendaftaranInput = document.getElementById("jenis-pendaftaran");

    const isSiswaBaru = jenisPendaftaranInput.value === "siswa-baru";
    const formData = new FormData();

    formData.append("jenis_pendaftaran", jenisPendaftaranInput.value || "");
    formData.append(
      "nama_lengkap",
      document.getElementById("nama-lengkap").value || ""
    );
    formData.append(
      "jenis_kelamin",
      document.querySelector('input[name="jenis-kelamin"]:checked').value || ""
    );
    formData.append("nik", document.getElementById("nik").value || "");
    formData.append(
      "tempat_lahir",
      document.getElementById("tempat-lahir").value || ""
    );
    formData.append(
      "tanggal_lahir",
      document.getElementById("tanggal-lahir").value || ""
    );
    formData.append("agama", document.getElementById("agama").value) || "";
    formData.append(
      "kebutuhan_khusus_siswa",
      document.getElementById("kebutuhan-khusus").value || ""
    );
    formData.append(
      "alamat_rumah",
      document.getElementById("alamat").value || ""
    );
    formData.append("dusun", document.getElementById("dusun").value || "");
    formData.append(
      "kelurahan",
      document.getElementById("kelurahan").value || ""
    );
    formData.append(
      "kecamatan",
      document.getElementById("kecamatan").value || ""
    );
    formData.append("kota", document.getElementById("kabupaten").value || "");
    formData.append(
      "provinsi",
      document.getElementById("provinsi").value || ""
    );
    formData.append(
      "alat_transportasi",
      document.getElementById("transportasi").value || ""
    );
    formData.append(
      "jenis_tinggal",
      document.getElementById("jenis-tinggal").value || ""
    );
    formData.append(
      "telp_rumah",
      document.getElementById("telpon-rumah").value || ""
    );
    formData.append(
      "no_hp",
      document.getElementById("telpon-hape").value || ""
    );
    formData.append(
      "email",
      document.getElementById("email-pribadi").value || ""
    );

    formData.append(
      "nama_ayah",
      document.getElementById("ayah-nama").value || ""
    );
    formData.append(
      "tahun_lahir_ayah",
      document.getElementById("ayah-tahun-lahir").value || ""
    );
    formData.append(
      "pekerjaan_ayah",
      document.getElementById("pekerjaan-ayah").value || ""
    );
    formData.append(
      "pendidikan_ayah",
      document.getElementById("pendidikan-ayah").value || ""
    );
    formData.append(
      "kebutuhan_khusus_ayah",
      document.getElementById("kebutuhan-khusus-ayah").value || ""
    );
    formData.append(
      "penghasilan_ayah",
      document.getElementById("penghasilan-ayah").value || ""
    );

    formData.append(
      "nama_ibu",
      document.getElementById("ibu-nama").value || ""
    );
    formData.append(
      "tahun_lahir_ibu",
      document.getElementById("ibu-tahun-lahir").value || ""
    );
    formData.append(
      "pekerjaan_ibu",
      document.getElementById("pekerjaan-ibu").value || ""
    );
    formData.append(
      "pendidikan_ibu",
      document.getElementById("pendidikan-ibu").value || ""
    );
    formData.append(
      "kebutuhan_khusus_ibu",
      document.getElementById("kebutuhan-khusus-ibu").value || ""
    );
    formData.append(
      "penghasilan_ibu",
      document.getElementById("penghasilan-ibu").value || ""
    );

    formData.append(
      "nama_wali",
      document.getElementById("wali-nama").value || ""
    );
    formData.append(
      "tahun_lahir_wali",
      document.getElementById("wali-tahun-lahir").value || ""
    );
    formData.append(
      "pekerjaan_wali",
      document.getElementById("pekerjaan-wali").value || ""
    );
    formData.append(
      "pendidikan_wali",
      document.getElementById("pendidikan-wali").value || ""
    );
    formData.append(
      "kebutuhan_khusus_wali",
      document.getElementById("kebutuhan-khusus-wali").value || ""
    );
    formData.append(
      "penghasilan_wali",
      document.getElementById("penghasilan-wali").value || ""
    );

    formData.append(
      "tinggi_badan",
      document.getElementById("tinggi-badan").value || ""
    );
    formData.append(
      "berat_badan",
      document.getElementById("berat-badan").value || ""
    );
    formData.append(
      "jarak_ke_sekolah",
      document.getElementById("jarak-ke-sekolah").value || ""
    );
    formData.append(
      "waktu_tempuh_ke_sekolah",
      document.getElementById("waktu-ke-sekolah").value || ""
    );
    formData.append(
      "prestasi",
      document.getElementById("prestasi").value || ""
    );

    formData.append("bukti_bayar_ppdb", linkBerkasPPDB.link_pembayaran_ppdb);
    formData.append("kartu_keluarga", linkBerkasPPDB.link_kartu_keluarga);
    formData.append("akta_lahir", linkBerkasPPDB.link_akta_lahir);
    formData.append("pas_foto", linkBerkasPPDB.pas_foto);

    if (isSiswaBaru) {
      try {
        const response = await axios.post(
          baseURL+"/api/sekolah_sd/ppdb/store",
          formData
        );

        submitButton.classList.remove("bg-gray-300");
        submitButton.classList.add("bg-[#286D6B]");
        submitButton.textContent = "Kirim";
        submitButton.removeAttribute("disabled", "");

        if (response.data.status) {
          Swal.fire({
            title: "Sukses!",
            text: "Sukses Mengirim Form PPDB",
            icon: "success",
            confirmButtonText: "Ok",
          });
        } else {
          Swal.fire({
            title: "Gagal!",
            text: "Gagal Mengirim Form PPDB",
            icon: "error",
            confirmButtonText: "Ok",
          });
        }
      } catch (err) {
        submitButton.classList.remove("bg-gray-300");
        submitButton.classList.add("bg-[#286D6B]");
        submitButton.textContent = "Kirim";
        submitButton.removeAttribute("disabled", "");

        Swal.fire({
          title: "Gagal!",
          text: "Gagal Mengirim Form PPDB: " + err.message,
          icon: "error",
          confirmButtonText: "Ok",
        });
      }
    } else {
      formData.append(
        "nama_asal_sekolah",
        document.getElementById("nama-asal-sekolah").value || ""
      );
      formData.append(
        "npsn_asal_sekolah",
        document.getElementById("npsn-asal-sekolah").value || ""
      );
      formData.append("nisn", document.getElementById("nisn").value || "");

      try {
        const response = await axios.post(
          baseURL+"/api/sekolah_sd/ppdb/store",
          formData
        );

        submitButton.classList.remove("bg-gray-300");
        submitButton.classList.add("bg-[#286D6B]");
        submitButton.textContent = "Kirim";
        submitButton.removeAttribute("disabled", "");

        if (response.data.status) {
          Swal.fire({
            title: "Sukses!",
            text: response.data.message || "Berhasil mengirim form PPDB",
            icon: "success",
            confirmButtonText: "Ok",
          });
        } else {
          Swal.fire({
            title: "Gagal!",
            text: response.data.message || "Gagal Mengirim Form PPDB",
            icon: "error",
            confirmButtonText: "Ok",
          });
        }
      } catch (err) {
        submitButton.classList.remove("bg-gray-300");
        submitButton.classList.add("bg-[#286D6B]");
        submitButton.textContent = "Kirim";
        submitButton.removeAttribute("disabled", "");

        Swal.fire({
          title: "Gagal!",
          text: "Gagal Mengirim Form PPDB: " + err.message,
          icon: "error",
          confirmButtonText: "Ok",
        });
      }
    }
  } else {
    submitButton.classList.remove("bg-gray-300");
    submitButton.classList.add("bg-[#286D6B]");
    submitButton.textContent = "Kirim";
    submitButton.removeAttribute("disabled", "");
    form.reportValidity();
  }
}

async function validateAndCompressFile(input, previewId) {
  const file = input.files[0];
  const maxSize = 512 * 1024; // 512KB
  const validTypes = ["image/jpeg", "image/jpg", "image/png"];
  const loadingElement = document.getElementById(`${previewId}-loading`);
  const previewElement = document.getElementById(`${previewId}-preview`);

  if (!validTypes.includes(file.type)) {
    alert("Mohon upload file dengan format JPEG, JPG atau PNG.");
    input.value = "";
    return;
  }

  loadingElement.classList.remove("hidden");

  try {
    const pngFile = await convertToPNG(file);

    let uploadFile = pngFile;
    if (pngFile.size > maxSize) {
      alert("Ukuran file melebihi 512KB. File akan dikompres.");
      const options = {
        maxSizeMB: 0.4,
        maxWidthOrHeight: 768,
        useWebWorker: true,
      };
      uploadFile = await imageCompression(pngFile, options);
    }

    await uploadFileToServer(uploadFile, previewId, previewElement);
  } catch (err) {
    console.error(err);
    Swal.fire({
      title: "Gagal!",
      text: "Gagal Mengupload File: " + err.message,
      icon: "error",
      confirmButtonText: "Ok",
    });
  } finally {
    loadingElement.classList.add("hidden");
  }
}

async function convertToPNG(file) {
  return new Promise((resolve, reject) => {
    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");
    const img = new Image();

    img.onload = () => {
      canvas.width = img.width;
      canvas.height = img.height;
      ctx.drawImage(img, 0, 0);
      canvas.toBlob((blob) => {
        if (blob)
          resolve(
            new File([blob], `${file.name.split(".")[0]}.png`, {
              type: "image/png",
            })
          );
        else reject(new Error("Failed to convert image to PNG"));
      }, "image/png");
    };

    img.onerror = (err) => reject(err);
    img.src = URL.createObjectURL(file);
  });
}

async function uploadFileToServer(file, previewId, previewElement) {
  const formData = new FormData();
  formData.append("file_data", file);

  try {
    const response = await axios.post(
      baseURL+"/api/sekolah_sd/upload",
      formData
    );

    if (response.data.status) {
      const url = URL.createObjectURL(file);
      previewElement.src = url;
      previewElement.classList.remove("hidden");

      const data = response.data.data;
      switch (previewId) {
        case "bukti-pembayaran":
          linkBerkasPPDB.link_pembayaran_ppdb = data;
          break;
        case "kartu-keluarga":
          linkBerkasPPDB.link_kartu_keluarga = data;
          break;
        case "akta-lahir":
          linkBerkasPPDB.link_akta_lahir = data;
          break;
        case "pas-foto":
          linkBerkasPPDB.pas_foto = data;
          break;
      }
    } else {
      throw new Error("Gagal Mengupload File");
    }
  } catch (err) {
    throw new Error(err.message);
  }
}
