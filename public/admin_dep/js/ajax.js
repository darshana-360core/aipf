
if ($("#grade").length != 0) {
    $('#grade').change(function () {
        var gradeID = $(this).val();
        if (gradeID) {
            $.ajax({
                type: "GET",
                url: "/api/get-standard-list?grade_id=" + gradeID,
                success: function (res) {
                    if (res) {
                        $("#standard").empty();
                        $("#standard").append('<option value="">Select</option>');
                        $.each(res, function (key, value) {
                            $("#standard").append('<option value="' + key + '">' + value + '</option>');
                        });
                        $("#division").empty();

                    } else {
                        $("#standard").empty();
                    }
                }
            });
        } else {
            $("#standard").empty();
            $("#division").empty();
        }
    });
}
if ($("#standard").length != 0) {
    $('#standard').on('change', function () {
        var standardID = $(this).val();
        if (standardID) {
            $.ajax({
                type: "GET",
                url: "/api/get-division-list?standard_id=" + standardID,
                success: function (res) {
                    if (res) {
                        $("#division").empty();
                        $("#division").append('<option value="">Select</option>');
                        $.each(res, function (key, value) {
                            $("#division").append('<option value="' + key + '">' + value + '</option>');
                        });

                    } else {
                        $("#division").empty();
                    }
                }
            });
        } else {
            $("#division").empty();
        }

    });
}


if ($("#gradeS").length != 0) {
    $('#gradeS').change(function () {
        var gradeID = $(this).val();
        if (gradeID) {
            $.ajax({
                type: "GET",
                url: "/api/get-standard-list?grade_id=" + gradeID,
                success: function (res) {
                    if (res) {
                        $("#standardS").empty();
                        $("#standardS").append('<option value="">Select</option>');
                        $.each(res, function (key, value) {
                            $("#standardS").append('<option value="' + key + '">' + value + '</option>');
                        });
                        $("#subject").empty();

                    } else {
                        $("#subject").empty();
                    }
                }
            });
        } else {
            $("#standardS").empty();
            $("#subject").empty();
        }
    });
}
if ($("#standardS").length != 0) {
    $('#standardS').on('change', function () {
        var standardID = $(this).val();
        if (standardID) {
            $.ajax({
                type: "GET",
                url: "/api/get-subject-list?standard_id=" + standardID,
                success: function (res) {
                    if (res) {
                        $("#subject").empty();
                        $("#subject").append('<option value="">Select</option>');
                        $.each(res, function (key, value) {
                            $("#subject").append('<option value="' + key + '">' + value + '</option>');
                        });

                    } else {
                        $("#subject").empty();
                    }
                }
            });
        } else {
            $("#subject").empty();
        }

    });
}