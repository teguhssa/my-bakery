<?php
// mengatur waktu UTC
date_default_timezone_set('UTC');
// memasukan koneksi
include_once('../../../config/index.php');
include('../../../helper/index.php');
// memulai session
session_start();

function generateReport($dataReports, $filename)
{
    $total = 0;
    $prevOrder = null;
    $output = '
    <table style="border: 1px solid black">
        <thead>
            <tr>
                <th class="fw-bold text-center" colspan="6" style="border: 1px solid black">Laporan harian</th>
            </tr>
            <tr>
                <th style="border: 1px solid black">Tanggal</th>
                <th style="border: 1px solid black">No. Order</th>
                <th style="border: 1px solid black">Barang</th>
                <th style="border: 1px solid black">Harga barang</th>
                <th style="border: 1px solid black">Qty</th>
                <th style="border: 1px solid black">Amount</th>
            </tr>
        </thead>
        <tbody>';


    foreach ($dataReports as $data) {
        if ($prevOrder === $data['no_order']) {
            $data['amount'] = "-";
        }

        $prevOrder = $data['no_order'];

        if (is_numeric($data['amount'])) {
            $total += $data['amount'];
        }

        $output .= '
        <tr>
            <td style="border: 1px solid black">' . $data['order_date'] . '</td>
            <td style="border: 1px solid black">' . $data['no_order'] . '</td>
            <td style="border: 1px solid black">' . $data['bakery_name'] . '</td>
            <td style="border: 1px solid black">' . rupiah($data['price']) . '</td>
            <td style="border: 1px solid black">' . $data['qty'] . '</td>
            <td style="border: 1px solid black">' . ($data['amount'] !== "-" ? rupiah($data['amount']) : "-") . '</td>
        </tr>';
    }


    // while ($data = mysqli_fetch_assoc($dataReports)) {
    //     $total += $data['amount'];
    //     $output .= '
    //             <tr>
    //                 <td style="border: 1px solid black">' . $data['order_date'] . '</td>
    //                 <td style="border: 1px solid black">' . $data['no_order'] . '</td>
    //                 <td style="border: 1px solid black">' . $data['bakery_name'] . '</td>
    //                 <td style="border: 1px solid black">' . rupiah($data['price']) . '</td>
    //                 <td style="border: 1px solid black">' . $data['qty'] . '</td>
    //                 <td style="border: 1px solid black">' . rupiah($data['amount']) . '</td>
    //             </tr>';
    // }
    $output .= '
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="border: 1px solid black;text-align:center; font-weight: bold; background: #D0CECE">Total</td>
                            <td class="bg-warning" style="border: 1px solid black; background: #A9D08E;">' . rupiah($total) . '</td>
                        </tr>
                    </tfoot>
                </table>';

    // Set headers for Excel file download
    header('Content-Type:application/xls');
    header('Content-Disposition: attachment; filename=' . $filename . '.xls');

    // Output the generated table
    echo $output;
}

function setFlashAndRedirect($message, $redirectLocation)
{
    $_SESSION['flash_msg'] = $message;
    header("Location: $redirectLocation");
    exit;
}

if (isset($_POST['btnExportLaporan'])) {
    $output = "";

    switch ($_POST['filterType']) {
        case "day":
            $date = $_POST['date'];
            $filename =  'Laporan-penjualan-harian-' . $date;
            $qLaporanHarian = "SELECT o.created_at AS order_date, o.no_order, d.total_price AS amount, d.qty ,b.bakery_name, b.price, SUM(d.total_price) AS total
            FROM orders o
            JOIN order_detail d ON o.id = d.order_id
            JOIN bakeries b ON d.bakery_id = b.id
            WHERE o.status_order = 'done' AND DATE(o.created_at) = '$date'
            GROUP BY o.id, d.id;";

            $resultHarian = mysqli_query($conn, $qLaporanHarian);

            if (mysqli_num_rows($resultHarian) > 0) {
                generateReport($resultHarian, $filename);
            } else {
                setFlashAndRedirect('Data tidak ditemukan!', '../../penjualan.php');
            }
            break;

        case "week":
            $dateFrom = $_POST['date'];
            $dateTo = $_POST['date-to'];
            $filename =  'Laporan-penjualan-mingguan-' . $dateFrom . '-sampai-' . $dateTo;

            $dateFromObj = new DateTime($dateFrom);
            $dateToObj = new DateTime($dateTo);

            $interval = $dateFromObj->diff($dateToObj);
            $daysDifference = $interval->days;

            if ($daysDifference > 7) {
                setFlashAndRedirect('Tidak boleh lebih dari 7 hari!', 'Location: ../../penjualan.php');
            } else {

                $qLaporanMingguan = "SELECT o.created_at AS order_date, o.no_order, d.total_price AS amount, d.qty ,b.bakery_name, b.price, SUM(d.total_price) AS total
                FROM orders o
                JOIN order_detail d ON o.id = d.order_id
                JOIN bakeries b ON d.bakery_id = b.id
                WHERE o.status_order = 'done' AND DATE(o.created_at) BETWEEN '$dateFrom' AND '$dateTo'
                GROUP BY o.id, d.id;";

                $resultMingguan = mysqli_query($conn, $qLaporanMingguan);

                if (mysqli_num_rows($resultMingguan) > 0) {
                    generateReport($resultMingguan, $filename);
                } else {
                    setFlashAndRedirect('Data tidak ditemukan!', '../../penjualan.php');
                }
            }

            break;

        case "month":
            $monthData = $_POST['month'];

            $dataParts = explode('-', $monthData);

            $tahun = $dataParts[0];
            $bulan = $dataParts[1];

            $filename =  'Laporan-penjualan-bulanan-' . $monthData;

            $qLaporanBulanan = "SELECT o.created_at AS order_date, o.no_order, d.total_price AS amount, d.qty ,b.bakery_name, b.price, SUM(d.total_price) AS total
                FROM orders o
                JOIN order_detail d ON o.id = d.order_id
                JOIN bakeries b ON d.bakery_id = b.id
                WHERE o.status_order = 'done' AND MONTH(o.created_at) = '$bulan' AND YEAR(o.created_at) = '$tahun'
                GROUP BY o.id, d.id;";

            $resultBulanan = mysqli_query($conn, $qLaporanBulanan);

            if (mysqli_num_rows($resultBulanan) > 0) {
                generateReport($resultBulanan, $filename);
            } else {
                setFlashAndRedirect('Data tidak ditemukan!', '../../penjualan.php');
            }

            break;

        default:
            break;
    }
}
