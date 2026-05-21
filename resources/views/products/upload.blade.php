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

        <h3>Expected Excel Columns</h3>

        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Stock Level</th>
                <th>Rating</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>PROD-101</td>
                <td>EcoPro Wireless Mouse</td>
                <td>Electronics</td>
                <td>Logitech</td>
                <td>1499</td>
                <td>45</td>
                <td>4.4</td>
                <td>Active</td>
            </tr>
        </table>
    </div>
</body>

</html>