<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laravel 10 How To Setup Ajax Request Tutorial - Online Web Tutor</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        #frm-create-post label.error {
            color: red;
        }
    </style>
</head>

<body>

<div class="container" style="margin-top: 50px;">
    <h4 style="text-align: center;">Laravel 10 How To Setup Ajax Request Tutorial - Online Web Tutor</h4>
    <form action="javascript:void(0)" id="frm-create-post" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" required id="name" name="name" placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" required name="description"
                      placeholder="Enter description"></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" id="submit-post">Submit</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#frm-create-post").validate({

        submitHandler: function() {

            var name = $("#name").val();
            var description = $("#description").val();
            var status = $("#status").val();

            // processing ajax request
            $.ajax({
                url: "{{ route('postSubmit') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    name: name,
                    description: description,
                    status: status
                },
                success: function(data) {
                    // log response into console
                    console.log(data);
                }
            });
        }
    });
</script>
</body>

</html>
