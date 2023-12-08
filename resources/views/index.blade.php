<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Ajax Pagination</title>
    <style>
        #content {
            margin-top: 20px;
        }

        .book-item {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .book-image {
            max-width: 100px;
            max-height: 100px;
        }
        .row {
            text-align: center;
        }
        .page-link {
            cursor: pointer;
        }
        .pagination-box {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .book-image {
            max-width: 150px;  /* Increase the max-width as needed */
            max-height: 150px; /* Increase the max-height as needed */
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1050;
            overflow: hidden;
            outline: 0;
        }

        .modal-dialog {
            position: relative;
            width: auto;
            margin: 10px;
        }

        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: .3rem;
            outline: 0;
        }

        .modal-header {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            margin-bottom: 0;
            line-height: 1.5;
        }

        .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: 15px;
        }
        .modal.show .modal-dialog {
            margin: 0 auto;
        }
        .active {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<!-- Add this modal structure at the end of the body -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Image Preview" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<body>

<div id="content"></div>
<div id="content"></div>
<div class="container mt-5">
    <div id="content"></div>
    <div>
        <nav>
            <ul id="pagination" class="pagination justify-content-center"></ul>
        </nav>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('js/pagination.js') }}"></script>
</body>
</html>
