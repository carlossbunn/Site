<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Fotos - Anos 2000</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background: linear-gradient(45deg, #ff8c00, #ff00ff, #00ffff);
            color: #fff;
            margin: 0;
            padding: 0;
            text-align: center;
            font-size: 1.5rem; /* Aumentado */
        }
        #uploadSection {
            width: 100%;
            min-height: 500px;
            background: linear-gradient(90deg, #ff1493, #1e90ff);
            padding: 20px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            border: 5px dotted #ffffff;
        }
        #conteudo {
            max-width: 800px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.8);
            color: #333;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            font-size: 1.6rem; /* Aumentado */
        }
        #titulo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        #titulo img {
            max-width: 200px;
            border: 5px solid #ffffff;
            border-radius: 50%;
        }
        h2 {
            font-size: 3rem; /* Aumentado */
            color: #ff4500;
            text-shadow: 2px 2px 3px #000000;
        }
        form {
            margin-top: 20px;
            font-size: 1.5rem; /* Aumentado */
        }
        input[type="text"], textarea, input[type="file"] {
            width: 80%;
            margin: 10px auto;
            padding: 15px; /* Aumentado */
            border: 2px solid #ff4500;
            border-radius: 10px;
            font-size: 1.2rem; /* Aumentado */
            color: #333;
        }
        input[type="submit"] {
            background-color: #ff4500;
            color: #fff;
            font-size: 1.5rem; /* Aumentado */
            padding: 15px 25px; /* Aumentado */
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #ff6347;
            transform: scale(1.1);
        }
        .foto {
            position: absolute;
            transition: transform 1s ease-in-out, opacity 1s ease-in-out;
            opacity: 0; /* Começa invisível */
            border: 3px solid #ff4500;
            border-radius: 50%;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }
        #detalhes_fotos {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px auto;
            max-width: 1200px;
            gap: 20px;
        }
        .detalhe_foto {
            width: 250px;
            background: linear-gradient(45deg, #ff1493, #1e90ff);
            color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            padding: 20px; /* Aumentado */
            text-align: center;
            border: 3px solid #fff;
            font-size: 1.6rem; /* Aumentado */
        }
        .detalhe_foto img {
            max-width: 100%;
            border-radius: 5px;
            border: 3px solid #ffffff;
        }
        .detalhe_foto h3 {
            margin-top: 10px;
            font-size: 2rem; /* Aumentado */
            color: #ffeb3b;
        }
        footer {
            margin-top: 50px;
            font-size: 1.5rem; /* Aumentado */
            color: #ffffff;
            background: #000;
            padding: 15px 0; /* Aumentado */
        }
    </style>
</head>
<body>
    <div id="uploadSection">
        <div id="conteudo">
            <div id="titulo">
                <img src="logo.png" alt="Título - Upload de Fotos">
            </div>
            <p>Bem-vindo ao portal de uploads, aqui você pode compartilhar seus momentos com todas as demais pessoas que entrarem nesse site, assim o site visa entregar apenas fotos fora de contexto mas vinda de uma boa vivencia :), se divirta</p>
            
            <h2>Fotos Carregadas</h2>
            <div id="fotos">
                <?php
                include 'db_connect.php';
                $result = $conn->query("SELECT caminho_arquivo FROM fotos ORDER BY id DESC");

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<img src='uploads/" . htmlspecialchars($row['caminho_arquivo']) . "' class='foto'>";
                    }
                } else {
                    echo "<p>Nenhuma foto carregada ainda.</p>";
                }
                $conn->close();
                ?>
            </div>
            <h2>Envie sua Foto</h2>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label>
                    Título da foto:
                    <input type="text" name="titulo" placeholder="Título da foto" required>
                </label>
                <br>
                <label>
                    Descrição da foto:
                    <textarea name="descricao" placeholder="Descrição da foto"></textarea>
                </label>
                <br>
                <label>
                    Foto:
                    <input type="file" name="foto" required>
                </label>
                <br>
                <input type="submit" value="Enviar Foto">
            </form>
        </div>
    </div>
    <h2>Detalhes das Fotos Carregadas</h2>
    <div id="detalhes_fotos">
        <?php
        include 'db_connect.php';
        $result = $conn->query("SELECT titulo, descricao, caminho_arquivo, data_upload FROM fotos ORDER BY id DESC");

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='detalhe_foto'>";
                echo "<h3>" . htmlspecialchars($row['titulo']) . "</h3>";
                echo "<p>" . nl2br(htmlspecialchars($row['descricao'])) . "</p>";
                echo "<p><strong>Data de upload:</strong> " . date('d/m/Y', strtotime($row['data_upload'])) . "</p>";
                echo "<img src='uploads/" . htmlspecialchars($row['caminho_arquivo']) . "'>";
                echo "</div>";
            }
        } else {
            echo "<p>Nenhuma foto carregada ainda.</p>";
        }
        $conn->close();
        ?>
    </div>
    <footer>
        <p>Site de Upload de Fotos © 2000s Style | Desenvolvido com amor 💖</p>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let fotos = document.querySelectorAll('.foto');
            let uploadSection = document.getElementById('uploadSection');
            let indexAtual = 0;

            function adicionarFoto() {
                if (fotos.length === 0) return;

                let novaFoto = fotos[indexAtual].cloneNode(true);

                let tamanho = Math.random() * 100 + 50;
                novaFoto.style.width = `${tamanho}px`;
                novaFoto.style.height = 'auto';

                let x = Math.random() * (uploadSection.offsetWidth - tamanho);
                let y = Math.random() * (uploadSection.offsetHeight - tamanho);

                novaFoto.style.left = `${x}px`;
                novaFoto.style.top = `${y}px`;

                novaFoto.style.transform = `rotate(${Math.random() * 30 - 15}deg)`;
                novaFoto.style.opacity = 1;

                uploadSection.appendChild(novaFoto);

                indexAtual = (indexAtual + 1) % fotos.length;

                setTimeout(() => {
                    novaFoto.style.opacity = 0;
                    setTimeout(() => {
                        novaFoto.remove();
                    }, 1000);
                }, 30000);
            }

            setInterval(adicionarFoto, 2000);
        });
    </script>
</body>
</html>

