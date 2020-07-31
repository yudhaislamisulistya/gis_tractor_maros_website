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
                                    <li><a href="tambah_informasi.php">Tambah</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <table id="data_table_informasi" class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Konten</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data_informasi_body">

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
                        <input type="text" class="form-control" placeholder="Judul" id="judulEdit" required>
                    </div>
                    <div class="form-group form-float">
                        <input type="text" class="form-control" placeholder="Konten" id="kontenEdit" required>
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
    async function getDataInformation() {
        var wsHtml = '';
        if ($.fn.DataTable.isDataTable('#data_table_informasi')) {
            await $('#data_table_informasi').DataTable().destroy();
        }

        await $('#data_table_informasi tbody').empty();

        await db.collection("informations").get().then((querySnapshot) => {
            querySnapshot.forEach((doc) => {

                wsHtml += `<tr>`;
                wsHtml += `<td>` + doc.data().judul + `</td>`;
                wsHtml += `<td>` + doc.data().konten + `</td>`;
                wsHtml += `<td>
                                <button data-toggle="modal" data-target="#editData" class="btn btn-primary" id="btnEditTractor" data-id="` + doc.id + `"><i class="material-icons">mode_edit</i><span></button>
                                <button class="btn btn-danger" id="btnDeleteTractor" data-id="` + doc.id + `"><i class="material-icons">delete_forever</i><span></button>
                            </td>`;
                wsHtml += `</tr>`;
            });
        });

        await $('#data_table_informasi > tbody:last').append(wsHtml);

        var datatableevent = await $('#data_table_informasi').DataTable({
            "order": [
                [2, "desc"]
            ],
        });
    }

    $(document).ready(function () {
        getDataInformation();
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
                var data_information_id = $(this).data('id');
                console.log(data_information_id);
                db.collection("informations")
                    .doc(data_information_id)
                    .delete()
                    .then(function() {
                        getDataInformation();
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
        var data_information_edit = $(this).data('id');
        $("#doc").val(data_information_edit);
        db.collection("informations").doc(data_information_edit).get().then((doc) => {
            $("#judulEdit").val(doc.data().judul);
            $("#kontenEdit").val(doc.data().konten);
        });
    });

    $(document).on("click", '#submitEditData', function() {
        var today = new Date();
        var date = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var datetime = date + " " + time;
        judul = $('#judulEdit').val();
        konten = $('#kontenEdit').val();
        $("#submitEditData").addClass("disabled");
        db.collection("informations").doc($("#doc").val()).update({
            judul: judul,
            konten: konten,
            updated_at: datetime,
        })
        .then(function(docRef) {
            getDataInformation();
            $("#submitEditData").removeClass("disabled");
            Swal.fire(
                'Status!',
                'Data Berhasil Ditambahkan!',
                'success'
            )
        })
        .catch(function(error) {
            console.log(error);
            $("#submitEditData").removeClass("disabled");
            Swal.fire(
                'Status!',
                'Data Gagal Ditambahkan!',
                'error'
            )
        })
    });
</script>