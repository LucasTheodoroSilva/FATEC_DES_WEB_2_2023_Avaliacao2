<?php
class BancoDados
{
    private $host;
    private $username;
    private $password;
    private $bancodados;
    private $connection;

    public function __construct($host, $username, $password, $bancodados)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->$bancodados = $bancodados;

        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->$bancodados);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }

    public function insert($name, $rg_cpf, $phone, $escola_publica)
    {
        $query = "INSERT INTO candidates (name, rg_cpf, phone, escola_publica) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("sssi", $name, $rg_cpf, $phone, $escola_publica);
        $stmt->execute();
        $stmt->close();
    }

    public function selectAll()
    {
        $query = "SELECT * FROM candidates";
        $result = $this->connection->query($query);
        $candidates = [];

        while ($row = $result->fetch_assoc()) {
            $candidates[] = $row;
        }

        return $candidates;
    }

    public function update($id, $name, $rg_cpf, $phone, $escola_publica)
    {
        $query = "UPDATE candidates SET name = ?, rg_cpf = ?, phone = ?, escola_publica = ? WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("sssii", $name, $rg_cpf, $phone, $escola_publica, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function delete($id)
    {
        $query = "DELETE FROM candidates WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
// BANCO DE DADOS - CONEXÃO
$db = new BancoDados('localhost', 'root', '', 'vestibular');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['rg_cpf']) && isset($_POST['phone'])) {
        $name = $_POST['name'];
        $rg_cpf = $_POST['rg_cpf'];
        $phone = $_POST['phone'];
        $escola_publica = isset($_POST['escola_publica']) && $_POST['escola_publica'] === 'on';

        $db->insert($name, $rg_cpf, $phone, $escola_publica);
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $db->delete($id);
}

if (isset($_POST['update'])) {
    $id = $_POST['update'];
    $name = $_POST['name'];
    $rg_cpf = $_POST['rg_cpf'];
    $phone = $_POST['phone'];
    $escola_publica = isset($_POST['escola_publica']) && $_POST['escola_publica'] === 'on';

    $db->update($id, $name, $rg_cpf, $phone, $escola_publica);
}

$candidates = $db->selectAll();
?>
<!-- INICIO DO HTML + PHP -->
<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <!-- FORM PARA PREENCHIMENTO -->
    <h1>Cadastro de Candidatos</h1>
    <h2>Cadastrar Novo Candidato</h2>
    <form method="POST">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="rg_cpf">RG/CPF:</label>
        <input type="text" id="rg_cpf" name="rg_cpf" required><br>

        <label for="phone">Telefone:</label>
        <input type="text" id="phone" name="phone" required><br>

        <label for="escola_publica">Oriundo de escola pública:</label>
        <input type="checkbox" id="escola_publica" name="escola_publica"><br>

        <input type="submit" value="Cadastrar">
    </form>

    <h2>Candidatos Inscritos</h2>
    <?php
    // -> MOSTRA LISTAGEM DE CANDIDATOS
    foreach ($candidates as $candidate) {
        echo "ID: " . $candidate['id'] . "<br>";
        echo "Nome: " . $candidate['name'] . "<br>";
        echo "RG/CPF: " . $candidate['rg_cpf'] . "<br>";
        echo "Telefone: " . $candidate['phone'] . "<br>";
        echo "Oriundo de escola pública: " . ($candidate['escola_publica'] ? "Sim" : "Não") . "<br>";
        // -> EXCLUIR CANDIDATO
        echo '<form method="POST">';
        echo '<input type="hidden" name="delete" value="' . $candidate['id'] . '">';
        echo '<input type="submit" value="Excluir">';
        echo '</form>';
        // -> ATUALIZAR CANDIDATO
        echo '<form method="POST">';
        echo '<input type="hidden" name="update" value="' . $candidate['id'] . '">';
        echo 'Novo nome: <input type="text" name="name" required><br>';
        echo 'Novo RG/CPF: <input type="text" name="rg_cpf" required><br>';
        echo 'Novo telefone: <input type="text" name="phone" required><br>';
        echo 'Novo status de escola pública: <input type="checkbox" name="escola_publica"><br>';
        echo '<input type="submit" value="Atualizar">';
        echo '</form>';

        echo "<br><br>";
    }
    ?>
</body>

</html>