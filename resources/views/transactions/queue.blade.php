<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Servis Kendaraan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .header {
            background-color: #fff;
            padding: 20px 0;
            text-align: center;
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 30px;
        }
        .header h1 {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .header p {
            color: #6c757d;
            margin: 0;
        }
        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 0 15px;
        }
        .page-title h3 {
            font-weight: 600;
            margin: 0;
        }
        .page-title h5 {
            font-weight: 600;
            margin: 0;
        }
        .column-box {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            min-height: 500px;
        }
        .column-header {
            font-size: 18px;
            font-weight: 600;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 15px;
            color: #343a40;
        }
        .queue-card {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }
        .queue-number {
            font-size: 48px;
            font-weight: 700;
            color: #212529;
            width: 80px;
            text-align: center;
            line-height: 1;
            margin-right: 15px;
            border-right: 1px solid #dee2e6;
            padding-right: 15px;
        }
        .queue-number span {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .queue-details {
            flex-grow: 1;
        }
        .queue-details ul {
            list-style-type: disc;
            padding-left: 20px;
            margin: 0;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Mandiri Motor</h1>
        <p>Jln. Pendidikan, Kec. Ciawi<br>Kab. Tasikmalaya</p>
    </div>
    <div class="container-fluid px-4">
        <div class="page-title">
            <h3>Antrian Servis Kendaraan</h3>
            <h5 id="currentDate">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</h5>
        </div>
        <div class="row">

            <div class="col-md-4 mb-4">
                <div class="column-box">
                    <div class="column-header">Daftar Antrian</div>
                    <div id="list-antre">
                        <div class="text-center text-muted mt-5">Memuat data...</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="column-box">
                    <div class="column-header">Proses Servis Mekanik</div>
                    <div id="list-proses">
                        <div class="text-center text-muted mt-5">Memuat data...</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="column-box">
                    <div class="column-header">Servis Selesai</div>
                    <div id="list-selesai">
                        <div class="text-center text-muted mt-5">Memuat data...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function generateCard(item, colorCode) {
            let plat = item.vehicle ? item.vehicle.plate_number : '-';
            let brand = item.vehicle ? item.vehicle.brand : '';
            let type = item.vehicle ? item.vehicle.type : '';
            let modelName = item.vehicle ? item.vehicle.model_name : '';
            let vehicleName = (brand + ' ' + type + ' ' + modelName).trim() || '-';
            return `
                <div class="queue-card" style="border-left: 6px solid ${colorCode};">
                    <div class="queue-number" style="color: ${colorCode};">
                        <span style="color: #6c757d;">No. Antrian</span>
                        ${item.id}
                    </div>
                    <div class="queue-details">
                        <strong>Kendaraan</strong>
                        <ul>
                            <li>No. Pol ${plat}</li>
                            <li>${vehicleName}</li>
                        </ul>
                    </div>
                </div>
            `;
        }
        function loadData() {
            $.ajax({
                url: "{{ route('transactions.queueData') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {

                    $('#list-antre').empty();
                    if(response.antre.length > 0) {
                        response.antre.forEach(item => {
                            $('#list-antre').append(generateCard(item, '#0dcaf0'));
                        });
                    } else {
                        $('#list-antre').html('<div class="text-center text-muted mt-4">Tidak ada antrean</div>');
                    }

                    $('#list-proses').empty();
                    if(response.proses.length > 0) {
                        response.proses.forEach(item => {
                            $('#list-proses').append(generateCard(item, '#ffc107'));
                        });
                    } else {
                        $('#list-proses').html('<div class="text-center text-muted mt-4">Tidak ada kendaraan di proses</div>');
                    }

                    $('#list-selesai').empty();
                    if(response.selesai.length > 0) {
                        response.selesai.forEach(item => {
                            $('#list-selesai').append(generateCard(item, '#198754'));
                        });
                    } else {
                        $('#list-selesai').html('<div class="text-center text-muted mt-4">Belum ada servis selesai</div>');
                    }
                },
                error: function() {
                    console.error("Gagal mengambil data antrean");
                }
            });
        }
        $(document).ready(function() {
            loadData(); // Load first time
            setInterval(loadData, 3000); // Poll every 3 seconds for realtime feel
        });
    </script>
</body>
</html>
