<?php

include_once "header.php";

?>


<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Daftar Tractor
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i> GIS Tractor</a></li>
                    <li class="breadcrumb-item active">Daftar Tractor</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Data Tractor</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu slideUp float-right">
                                    <li><a href="tambah_tractor.php">Tambah</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <table id="data_table_tractor" class="table table-bordered table-striped table-hover dataTable js-exportable table-responsive">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Kelompok Tani</th>
                                    <th>Pemilik</th>
                                    <th>Alamat</th>
                                    <th>Nama Barang</th>
                                    <th>Merek</th>
                                    <th>Volume</th>
                                    <th>Nomor Mesin</th>
                                    <th>Nomor Rangka</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>kondisi</th>
                                    <th>Tanggal Buat</th>
                                    <th>Tanggal Ubah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data_tractor_body">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table --> 
    </div>
</section>

<!-- Large Size -->
<div class="modal fade" id="editData" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="editDataLabel">Ubah Data</h4>
            </div>
            <div class="modal-body">
            <div id="form_validation">
                <input type="hidden" id="doc">
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Nama Kelompok Tani" id="namaKelompokTaniEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Nama Pemilik" id="namaPemilikEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Alamat" id="alamatEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Nama Barang" id="namaBarangEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Merek" id="merekEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Volume" id="volumeEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Nomor Mesin" id="nomorMesinEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Nomor Rangka" id="nomorRangkaEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Titik Koordinat Latitude" id="latitudeEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Titik Koordinat Longitude" id="longitudeEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Kondisi" id="kondisiEdit" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-raised btn-primary btn-round waves-effect" id="submitEditData">SUBMIT</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<?php

include_once "footer.php";

?>

<script>
    var db = firebase.firestore();
    async function getDataTractor() {
        var wsHtml = '';
        if ($.fn.DataTable.isDataTable('#data_table_tractor')) {
            await $('#data_table_tractor').DataTable().destroy();
        }

        await $('#data_table_tractor tbody').empty();

        await db.collection("tractors").get().then((querySnapshot) => {
            querySnapshot.forEach((doc) => {
                var storageRef = firebase.storage().ref();
                var imageUrlKami;
                storageRef.child(doc.data().name_image).getDownloadURL().then(function(url) {
                    imageUrlKami = url;
                    document.getElementById(doc.id).innerHTML = `<img src="` + imageUrlKami + `" width="50px" height="50px"></img>`;
                })

                wsHtml += `<tr>`;
                wsHtml += `<td  id="` + doc.id + `">
                            </td>`;
                wsHtml += `<td>` + doc.data().nama_kelompok_tani + `</td>`;
                wsHtml += `<td>` + doc.data().nama_pemilik + `</td>`;
                wsHtml += `<td>` + doc.data().alamat + `</td>`;
                wsHtml += `<td>` + doc.data().nama_barang + `</td>`;
                wsHtml += `<td>` + doc.data().merek + `</td>`;
                wsHtml += `<td>` + doc.data().volume + `</td>`;
                wsHtml += `<td>` + doc.data().nomor_mesin + `</td>`;
                wsHtml += `<td>` + doc.data().nomor_rangka + `</td>`;
                wsHtml += `<td>` + doc.data().latitude + `</td>`;
                wsHtml += `<td>` + doc.data().longitude + `</td>`;
                wsHtml += `<td>` + doc.data().kondisi + `</td>`;
                wsHtml += `<td>` + doc.data().created_at + `</td>`;
                wsHtml += `<td>` + doc.data().updated_at + `</td>`;
                wsHtml += `<td>
                                <button data-toggle="modal" data-target="#editData" class="btn btn-primary" id="btnEditTractor" data-id="` + doc.id + `"><i class="material-icons">mode_edit</i><span></button>
                                <button class="btn btn-danger" id="btnDeleteTractor" data-id="` + doc.id + `"><i class="material-icons">delete_forever</i><span></button>
                            </td>`;
                wsHtml += `</tr>`;
            });
        });

        await $('#data_table_tractor > tbody:last').append(wsHtml);

        var datatableevent = await $('#data_table_tractor').DataTable({
            "order": [
                [2, "desc"]
            ],
        });
    }

    $(document).ready(function () {
        getDataTractor();
    });

    $(document).on("click", '#btnDeleteTractor', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Data Tidak Dapat Dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Hapus'
        }).then((result) => {
            if (result.value) {
                var data_tractor_id = $(this).data('id');
                console.log(data_tractor_id);
                db.collection("tractors")
                    .doc(data_tractor_id)
                    .delete()
                    .then(function() {
                        getDataTractor();
                        Swal.fire(
                            'Status!',
                            'Data Berhasil Dihapus!',
                            'success'
                        )
                    })
                    .catch(function(error) {
                        console.log(error);
                        Swal.fire(
                            'Status!',
                            'Data Gagal Dihapus!',
                            'error'
                        )
                    })
            }
        })
    });

    $(document).on("click", '#btnEditTractor', function() {
        var data_tractor_edit = $(this).data('id');
        $("#doc").val(data_tractor_edit);
        db.collection("tractors").doc(data_tractor_edit).get().then((doc) => {
            $("#namaKelompokTaniEdit").val(doc.data().nama_kelompok_tani);
            $("#namaPemilikEdit").val(doc.data().nama_pemilik);
            $("#alamatEdit").val(doc.data().alamat);
            $("#namaBarangEdit").val(doc.data().nama_barang);
            $("#merekEdit").val(doc.data().merek);
            $("#volumeEdit").val(doc.data().volume);
            $("#nomorMesinEdit").val(doc.data().nomor_mesin);
            $("#nomorRangkaEdit").val(doc.data().nomor_rangka);
            $("#latitudeEdit").val(doc.data().latitude);
            $("#longitudeEdit").val(doc.data().longitude);
            $("#kondisiEdit").val(doc.data().kondisi);
        });
    });

    $(document).on("click", '#submitEditData', function() {
        var today = new Date();
        var date = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var datetime = date + " " + time;
        namaKelompokTani = $('#namaKelompokTaniEdit').val();
        namaPemilik = $('#namaPemilikEdit').val();
        alamat = $('#alamatEdit').val();
        namaBarang = $('#namaBarangEdit').val();
        merek = $('#merekEdit').val();
        volume = $('#volumeEdit').val();
        nomorMesin = $('#nomorMesinEdit').val();
        nomorRangka = $('#nomorRangkaEdit').val();
        latitude = $('#latitudeEdit').val();
        longitude = $('#longitudeEdit').val();
        kondisi = $('#kondisiEdit').val();
        $("#submitEditData").addClass("disabled");
        db.collection("tractors").doc($("#doc").val()).update({
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
            updated_at: datetime,
        })
        .then(function(docRef) {
            getDataTractor();
            $("#submitEditData").removeClass("disabled");
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
</script>