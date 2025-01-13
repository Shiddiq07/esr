<script type="text/javascript">
    $(document).on('change', '#id_unit', function(event) {
        event.preventDefault();

        let id = $(this).val();
        if (id) {
            getDepartment(id);
            getAtasan({
                id_unit: id
            });
        }

    });

    // $(document).on('change', '#id_unit', function(event) {
    //     event.preventDefault();

    //     let id_unit = $("#id_unit").val();
    //     // let id_department = $("#id_department").val();
    //     // let id_grade = $("#id_grade").val();
    //     // let golongan = $("#id_golongan").val();

    //     if (
    //         id_unit.length > 0 
    //         // && id_department.length > 0 
    //         // && id_grade
    //         // && golongan
    //     ) {
    //         getAtasan({
    //             id_unit: id_unit
    //             // id_department: id_department,
    //             // id_grade: id_grade,
    //             // golongan: golongan
    //         });
    //     }
    // });

    $(document).on('change', '#id_jenis_grading', function(event) {
        let id = $(this).val();

        if (id) {
            getGrade(id);
        }
    });

    var designations = '';

    $(document).on('change', '#id_grading_type_id', function(event) {
        let id = $(this).val();

        if (id) {
            getDesignation(id);
        }
    });

    var jabatan = '';

    $(document).on('change', '#id_jenis_grading, #id_grade, #id_golongan', function(event) {
        let grading_type = $('#id_jenis_grading').val();
        let grade = $('#id_grade').val();
        let golongan = $('#id_golongan').val();

        if (grading_type && grade && golongan) {
            setKelasJabatan({
                grading_type: grading_type,
                grade: grade,
                golongan: golongan
            });
        }
    });

    $(document).on('change', '#id_job_title, #id_designation', function(event) {
        setTimeout(() => {
            let designation_selected = $('#id_designation').val();
            let new_job_title = jabatan;

            if (designation_selected) {
                let designation = designations[designation_selected];

                if (designation.combined == 1) {
                    new_job_title = jabatan +' '+ designation.name;
                } else if (designation.combined == 0) {
                    new_job_title = designation.name;
                }
            }

            $('#id_job_title').val(new_job_title.trim());
        }, 500);
    });

    $(document).on('change', '#id_grade', function(event) {
        let grade = $(this).val();

        if (grade) {
            getGolongan(grade);
        }
    });

    function setKelasJabatan(params) {
        $.ajax({
            url: '<?= site_url('/rbac/user/get-kelas-jabatan') ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                grading_type: params.grading_type,
                grade: params.grade,
                golongan: params.golongan
            },
        })
        .done(function(res) {
            $("#id_kelas_jabatan").val(res.data.kelas);
            $("#id_job_title").val(res.data.jabatan).trigger('change');

            jabatan = res.data.jabatan;
        })
        .fail(function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            console.error(err.Message);
        })
        .always(function() {
        });
    }

    function getDepartment(unit_id, default_value = null) {
        if (!unit_id) {
            return false;
        }

        $.ajax({
            url: '<?= site_url('/rbac/user/get-department/') ?>'+ unit_id,
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            setDropdown(data, 'id_department', '- Pilih Department -', default_value);
        })
        .fail(function() {
            console.error("Get data department failed");
        });
    }

    function getAtasan(params, default_value) {
        $.ajax({
            url: '<?= base_url("/rbac/user/get-atasan") ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id_unit: params.id_unit,
                // id_department: params.id_department,
                // id_grade: params.id_grade,
                // golongan: params.golongan,
                [csrf_name] : csrf_hash
            },
        })
        .done(function(data) {
            // START SET DROPDOWN ATASAN
            setDropdown(data, 'id_atasan', '- Pilih Atasan -', default_value);
            // END SET DROPDOWN ATASAN
        })
        .fail(function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            console.error(err.Message);
        })
        .always(function() {
        });
    }

    function getGrade(jenis_grading_id, default_value = null) {
        if (!jenis_grading_id) {
            return false;
        }

        $.ajax({
            url: '<?= site_url('/rbac/user/get-grade') ?>',
            type: 'GET',
            dataType: 'json',
            data: {grading_type: jenis_grading_id},
        })
        .done(function(res) {
            // START SET DROPDOWN KELOMPOK
            setDropdown(res.data, 'id_grading_type_id', '- Pilih Kelompok -', default_value);
            // END SET DROPDOWN KELOMPOK
        })
        .fail(function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            console.error(err.Message);
        })
        .always(function() {
        });
    }

    function getDesignation(grading_type_id, default_value = null) {
        if (!grading_type_id) {
            return false;
        }

        $.ajax({
            url: '<?= site_url('/rbac/user/get-designation') ?>',
            type: 'GET',
            dataType: 'json',
            data: {kelompok: grading_type_id},
        })
        .done(function(res) {
            designations = res.data;

            // START SET DROPDOWN DESIGNATION
            let dropdown_designation = $("#id_designation");
            dropdown_designation.empty();

            dropdown_designation.append(`<option value="">- Pilih Designation -</option>`);
            $.each(res.data, function(index, val) {
                let selected = '';
                if (default_value == index) {
                    selected = 'selected';
                }

                dropdown_designation.append(`<option value="${index}" ${selected}>${val.name}</option>`);
            });

            dropdown_designation.focus();
            // END SET DROPDOWN DESIGNATION
        })
        .fail(function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            console.error(err.Message);
        })
        .always(function() {
        });
    }

    function getGolongan(grade, default_value = null) {
        if (!grade) {
            return false;
        }

        $.ajax({
            url: '<?= site_url("/rbac/user/get-golongan/") ?>' + grade,
            type: 'GET',
            dataType: 'json',
        })
        .done(function(res) {
            setDropdown(res.data, 'id_golongan', '- Pilih Golongan -', default_value)
        })
        .fail(function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            console.error(err.Message);
        });
    }
</script>
