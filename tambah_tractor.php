<?php

include_once "header.php";

?>

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Data Tractor
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i> GIS Tractor</a></li>
                    <li class="breadcrumb-item active">Tractor</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Basic Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Form Data Tractor</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="list_tractor.php">Daftar GIS Tractor</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div id="form_validation">
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Nama Kelompok Tani" id="namaKelompokTani" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Nama Pemilik" id="namaPemilik" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Alamat" id="alamat" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Nama Barang" id="namaBarang" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Merek" id="merek" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Volume" id="volume" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Nomor Mesin" id="nomorMesin" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Nomor Rangka" id="nomorRangka" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Titik Koordinat Latitude" id="latitude" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Titik Koordinat Longitude" id="longitude" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Kondisi" id="kondisi" required>
                            </div>
                            <fieldset class="form-group">
                            <input type="file" class="form-control" id="files" name="files[]" multiple>
                        </fieldset>
                            <button class="btn btn-raised btn-primary btn-round waves-effect" id="tambahData">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Validation --> 
    </div>
</section>

<?php

include_once "footer.php";

?>

<script>
    var db = firebase.firestore();
    $('#tambahData').on('click', function () {
        var makeCode = makeid(10);
        var today = new Date();
        var date = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var datetime = date + " " + time;
        namaKelompokTani = $('#namaKelompokTani').val();
        namaPemilik = $('#namaPemilik').val();
        alamat = $('#alamat').val();
        namaBarang = $('#namaBarang').val();
        merek = $('#merek').val();
        volume = $('#volume').val();
        nomorMesin = $('#nomorMesin').val();
        nomorRangka = $('#nomorRangka').val();
        latitude = $('#latitude').val();
        longitude = $('#longitude').val();
        kondisi = $('#kondisi').val();
        var storageRef = firebase.storage().ref();
        var file = document.getElementById("files").files[0];
        var thisRef = storageRef.child(file.name);
        $("#tambahData").addClass("disabled");
        thisRef.put(file).then(function(snapshot) {
                storageRef.child(file.name).getDownloadURL().then(function(url) {
                    db.collection("tractors").add({
                        nama_kelompok_tani: namaKelompokTani,
                        nama_pemilik: namaPemilik,
                        alamat: alamat,
                        nama_barang: namaBarang,
                        merek: merek,
                        volume: volume,
                        nomor_mesin: nomorMesin,
                        nomor_rangka: nomorRangka,
                        latitude: latitude,
                        longitude: longitude,
                        kondisi: kondisi,
                        url_image: url,
                        name_image: file.name,
                        created_at: datetime,
                        updated_at: datetime,
                    })
                    .then(function(docRef) {
                        $("#tambahData").removeClass("disabled");
                        Swal.fire(
                            'Status!',
                            'Data Berhasil Ditambahkan!',
                            'success'
                        )
                    })
                    .catch(function(error) {
                        console.log(error);
                        $("#btnSubmitMeeting").removeClass("disabled");
                        Swal.fire(
                            'Status!',
                            'Data Gagal Ditambahkan!',
                            'error'
                        )
                    })
                });
            });
    });

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
</script>