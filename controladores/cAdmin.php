    <?php
    require_once 'modelos/mUsuario.php';

    class CAdmin {
        
        public $vista;
        
        public function __construct() {
            $this->vista = '';

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            // Verificar que el usuario esté logueado y sea administrador
            session_start();
            if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'c') {
                header('Location: index.php');
                exit;
            }
        }
        
        public function menu() {
            $this->vista = 'menuAdmin';
            return ['nombreUsuario' => $_SESSION['nombreUsuario']];
        }
        
        public function deportesUsuarios() {
            $modeloUsuario = new MUsuario();
            $usuarios = $modeloUsuario->consultarDeportesUsuarios();
            
            $this->vista = 'deportesUsuarios';
            return ['usuarios' => $usuarios];
        }
        
        public function totalDeportes() {
            $modeloUsuario = new MUsuario();
            $total = $modeloUsuario->consultarTotalDeportes();
            
            $this->vista = 'totalDeportes';
            return ['total' => $total];
        }
        
        public function deportes() {
            $modeloUsuario = new MUsuario();
            $deportes = $modeloUsuario->consultarDeportesConTotal();
            
            $this->vista = 'deportes';
            return ['deportes' => $deportes];
        }
    }
?>
