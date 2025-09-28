<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Project Directory List</title>
    <style>
        .main-content {
            width: 60%;
            height: 90%;
            margin: auto;
            position: absolute;
            left: 20%;
            border-radius: 10px;
        }

        .folder-card {
            text-align: center;
        }

        .custom--card {
            min-height: 150px;
            background: #d5d8db;
            position: relative;
            box-shadow: 3px 4px 3px #ddd;
        }

        .card-footer {
            background-color: #ebeced;
        }

        .custom--card::before {
            position: absolute;
            left: 0;
            content: "";
            width: 50px;
            height: 26px;
            background-color: #d5d8db;
            top: -5px;
            border-radius: 0px 10px 10px 0px;
        }


        .folder-card a {
            text-decoration: none;
            text-transform: uppercase;
            color: #000;
            font-weight: 600;
            font-size: 18px;
        }

        .content-footer {
            position: absolute;
            bottom: 6%;
            width: 60%;
            left: 20%;
            display: flex;
            justify-content: center;
        }

        a.link {
            font-size: 12px !important;
            text-decoration: underline !important;
        }

        input#search {
            background: #ebeced;
            border: none;
            padding: 10px 50px;
        }

        .working-project .file-name {
            background: #ff0050;
            color: #fff;
            padding: 4px 5px;
            border-radius: 1px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-5">
        <div class="main-content  p-5">
            <div class="row justify-content-end">
                <div class="col-lg-4 mb-3 text-end">
                    <input class="search-input" placeholder="Search Directory" autocomplete="off" id="search"> <br>
                    <span> PHP: <?php echo PHP_VERSION ?></span>
                </div>
            </div>
            <div class="row">
                <?php
                $files          = scandir(dirname(__FILE__));
                $workingProject = "BUYMEACOFFEE";

                foreach ($files as $file) {
                    if (is_dir($file) && $file != '.' && $file != '..' && $file != 'xampp' && $file != 'webalizer') {
                        $isWorkingProject = strtoupper($file) == strtoupper($workingProject) ? 'working-project' : '';
                        echo "<div class='col-lg-3 mb-3'>
                    <div class='card  rounded border-0 folder-card w-100 custom--card mb-4 $isWorkingProject'>
                        <div class='card-body'></div>
                        <div class='card-footer'>
                        <a href='$file' class='file-name'>$file</a> 
                        <div class='d-flex justify-content-between'>
                            <a href='$file'  class='link'>Root</a>
                            <a href='$file/admin' class='link'>Admin</a>
                        </div>
                        </div>
                    </div>
                </div>";
                    }
                }
                ?>
            </div>
        </div>

    </div>
    <script>
        let search = document.getElementById('search');
        search.addEventListener('keyup', function(e) {
            let elements = document.getElementsByClassName('file-name');
            let searchValue = search.value.toUpperCase();
            Array.from(elements).forEach(element => {
                let elementText = element.innerHTML.toUpperCase();
                if (elementText.indexOf(searchValue) == -1) {
                    element.closest('.col-lg-3').style.display = "none";
                } else {
                    element.closest('.col-lg-3').style.display = "block";
                }
            });
        });
    </script>
</body>

</html>