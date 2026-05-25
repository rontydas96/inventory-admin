<!DOCTYPE html>
<html>

<head>
    <title>Upload Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            padding: 40px;
        }

        .card {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
        }

        .card-large {
            /* max-width: 700px; */
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
            margin-top: 40px;       
        }

        input[type="file"] {
            display: block;
            margin: 20px 0;
        }

        button,
        a {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            background: #47c54d;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f1f5f9;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Upload Products</h1>

        <p>Accepted formats: XLSX, XLS, CSV</p>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('products.upload.post') }}" enctype="multipart/form-data">
            @csrf

            <input type="file" name="file" required>
            <button type="submit">Upload & Sync</button>
            <a href="{{ route('dashboard') }}">Back to Dashboard</a>
        </form>
    </div>

    <div class="card-large">
        <h3>Expected Excel Columns</h3>

        <table>
            <tr>
                <th>SL. NO.</th>
                <th>MATERIAL CODE</th>
                <th>DESCRIPTION OF MATERIAL</th>
                <th>HSN CODE</th>
                <th>MAIN CATEGORY</th>
                <th>SUB CATEGORY</th>
                <th>UNIT</th>
                <th>GST PERCENTAGE</th>
                <th>COST(IN RS.) INCLUSIVE OF GST</th>
                <th>SELLING PRICE</th>
                <th>Available Quantity</th>
            </tr>
            <tr>
                <td>1</td>
                <td>110030141</td>
                <td>EcoPro Wireless Mouse</td>
                <td>HSN1</td>
                <td>Electronics</td>
                <td>Mouse</td>
                <td>NOS</td>
                <td>18</td>
                <td>1499</td>
                <td>1999</td>
                <td>45</td>
            </tr>
        </table>
    </div>
</body>

</html>