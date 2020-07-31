<?php

include_once "header.php";

?>


<!-- Main Content -->
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>Dashboard
                <small>Welcome to GIS Tractor</small>
                </h2>
            </div>            
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">
                <button class="btn btn-white btn-icon btn-round hidden-sm-down float-right m-l-10" type="button">
                    <i class="zmdi zmdi-plus"></i>
                </button>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i> GIS Tractor</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Data Terbaru GIS Tractor</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu slideUp">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body table-responsive members_profiles">
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
    </div>
</section>

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

        await db.collection("tractors").limit(5).get().then((querySnapshot) => {
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
</script>