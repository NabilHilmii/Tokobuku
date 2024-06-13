<!-- <div class="row">
<?php
                    $sql = "SELECT buku.judul_buku, buku.harga, buku.gambar, penulis.nama_penulis, penerbit.nama_penerbit 
                            FROM buku 
                            JOIN penulis ON buku.id_penulis = penulis.id_penulis 
                            JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit";
                    $result = $koneksi->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='col-lg-4 col-md-6 mb-4'>";
                            echo "<div class='card h-100'>";
                            echo "<img class='card-img-top' src='images/" . $row["gambar"] . "' alt='Book Cover'>";
                            echo "<div class='card-body'>";
                            echo "<h4 class='card-title'>" . $row["judul_buku"] . "</h4>";
                            echo "<h5>Price: $" . $row["harga"] . "</h5>";
                            echo "<p class='card-text'>Author: " . $row["nama_penulis"] . "</p>";
                            echo "<p class='card-text'>Publisher: " . $row["nama_penerbit"] . "</p>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "0 results";
                    }
                    $koneksi->close();
                    ?>
                </div>
            </div> -->