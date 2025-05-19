<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'vendor/autoload.php';
    require_once 'includes/db.php';

    try {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16
        ]);

        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    
        // Prevent any output before PDF generation
        ob_clean();
        
        // Now set headers
        header('Content-Type: application/pdf');

        $count = 1;

        $html = "
            <html>
               <head>
                    <style>
                          body {
                            font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif;
                            font-size: 12px;
                            padding: 20px;
                            color: #333;
                          }
                          table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 20px 0;
                          }
                          th, td {
                            border: 1px solid #000;
                            padding: 8px;
                            text-align: left;
                          }
                          th {
                            background-color: #f5f5f5;
                          }
                    </style>
               </head>
               <body>
                    <h1>Products List</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stocks</th>
                            </tr>
                        </thead>
                <tbody>
        ";

        foreach ($products as $product) {
            $html .= '
                <tr>
                        <td>' . $count++ . '</td>
                        <td>' . htmlspecialchars($product['name']) . '</td>
                        <td>' . htmlspecialchars($product['category']) . '</td>
                        <td>' . htmlspecialchars($product['price']) . '</td>
                        <td>' . htmlspecialchars($product['stocks']) . '</td>
                    </tr>
                ';
        }

        $html .= "
                    </tbody>
                </table>

                <div class=\"signature-section\">
                    <div class=\"signature\">
                    <p>__________________________________________</p>
                    <p><strong>General Manager</strong></p>
                    </div>
                </div>
            </body>
        </html>";
        
        $mpdf->SetHTMLFooter('
        <div style="text-align: left">
            Page {PAGENO} of {nbpg}
        </div>
        ');

        $mpdf->WriteHTML($html);
        $mpdf->Output('products.pdf', 'I');
        exit;
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form method="POST">
        <button type="submit" class="btn btn-primary">Generate PDF</button>
    </form>
</body>
</html>