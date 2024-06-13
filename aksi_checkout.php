<?php
session_start();
include 'proses/connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout_and_delete'])) {
    $username = $_SESSION['username'];

    // Mendapatkan id_user
    $sql = "SELECT id_user FROM user WHERE username = '" . $koneksi->real_escape_string($username) . "'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = intval($user['id_user']);

        // Mendapatkan data dari keranjang untuk user tertentu
        $cart_sql = "SELECT k.id_buku, k.jumlah, b.judul_buku, b.harga 
                     FROM keranjang k 
                     JOIN buku b ON k.id_buku = b.id_buku 
                     WHERE k.id_user = $user_id";
        $cart_result = $koneksi->query($cart_sql);

        if ($cart_result->num_rows > 0) {
            // Insert ke tabel pembelian
            $tanggal_pembelian = date('Y-m-d');
            $insert_pembelian_sql = "INSERT INTO pembelian (id_user, username, tanggal) VALUES ($user_id, '$username', '$tanggal_pembelian')";
            if ($koneksi->query($insert_pembelian_sql) === TRUE) {
                // Mendapatkan id_pembelian terakhir yang baru saja dimasukkan
                $id_pembelian = $koneksi->insert_id;

                // Persiapkan nilai-nilai multi-insert
                $values = [];

                // Persiapkan nilai-nilai untuk update jumlah jika id_user dan id_buku sama
                $updates = [];

                // Iterasi melalui data keranjang
                while ($row = $cart_result->fetch_assoc()) {
                    $book_id = $row['id_buku'];
                    $jumlah = $row['jumlah'];
                    $judul_buku = $koneksi->real_escape_string($row['judul_buku']);
                    $harga = $row['harga'];

                    // Periksa apakah buku sudah ada di invoice untuk user tertentu
                    $cek_invoice_sql = "SELECT id_buku FROM invoice WHERE id_pembelian = $id_pembelian AND id_buku = $book_id";
                    $cek_result = $koneksi->query($cek_invoice_sql);

                    if ($cek_result->num_rows > 0) {
                        // Jika sudah ada, tambahkan ke nilai-nilai untuk update jumlah
                        $updates[] = "($id_pembelian, $book_id, $jumlah)";
                    } else {
                        // Jika belum ada, tambahkan ke nilai-nilai multi-insert
                        $values[] = "($id_pembelian, $book_id, '$judul_buku', $harga, $jumlah)";
                    }
                }

                // Gabungkan nilai-nilai untuk update jumlah
                $update_clause = [];
                foreach ($updates as $update) {
                    $update_clause[] = "jumlah = jumlah + $update[2]";
                }
                $update_values = implode(", ", $update_clause);

                // Update jumlah buku jika id_user dan id_buku sama
                if (!empty($update_values)) {
                    $update_invoice_sql = "UPDATE invoice SET $update_values WHERE id_pembelian = $id_pembelian";
                    if ($koneksi->query($update_invoice_sql) === FALSE) {
                        echo "Error updating records: " . $koneksi->error;
                    }
                }

                // Gabungkan nilai-nilai multi-insert
                $values_clause = implode(", ", $values);

                // Lakukan multi-insert ke tabel invoice
                if (!empty($values_clause)) {
                    $insert_invoice_sql = "INSERT INTO invoice (id_pembelian, id_buku, judul_buku, harga, jumlah) VALUES $values_clause";
                    if ($koneksi->query($insert_invoice_sql) === FALSE) {
                        echo "Error inserting records into invoice: " . $koneksi->error;
                    }
                }

                // Insert ke tabel pembayaran dengan status "Tidak Dibayar"
                $pembayaran_sql = "INSERT INTO pembayaran (id_detail, status) 
                                   SELECT id_detail, 'Belum Dibayar' 
                                   FROM invoice 
                                   WHERE id_pembelian = $id_pembelian";
                if ($koneksi->query($pembayaran_sql) === FALSE) {
                    echo "Error inserting records into pembayaran: " . $koneksi->error;
                }

                // Hapus semua item dari keranjang untuk user tertentu
                $delete_sql = "DELETE FROM keranjang WHERE id_user = $user_id";
                if ($koneksi->query($delete_sql) === TRUE) {
                    // Redirect kembali ke halaman checkout setelah pembelian dan penghapusan berhasil
                    header("Location: order_page.php");
                    exit();
                } else {
                    echo "Error deleting records from cart: " . $koneksi->error;
                }
            } else {
                echo "Error inserting record into pembelian: " . $koneksi->error;
            }
        } else {
            echo "Cart is empty.";
        }
    } else {
        echo "User not found.";
    }
}
?>
