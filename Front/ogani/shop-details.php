<?php
session_start();
include("../../BD/conexion.php");
include "../../funciones/usuario.php";

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    $sql = "SELECT * FROM productos WHERE pro_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo "<p>Producto no encontrado.</p>";
        exit;
    }
} else {
    header("Location: shop-grid.php");
    exit;
}

// Consulta para obtener la sucursal con mayor inventario
$sucsql = "SELECT * FROM inventario i, sucursal s WHERE pro_id = " . $product_id . " AND i.suc_id = s.suc_id ORDER BY inv_existencia DESC LIMIT 1";
$sucres = mysqli_query($conn, $sucsql);
$selected_sucursal = null;
if (mysqli_num_rows($sucres) > 0) {
    $selected_sucursal = mysqli_fetch_array($sucres);
}

// Check if the form has been submitted
$formSubmitted = isset($_GET['agregar']);
$message = '';

if ($formSubmitted) {
    // Si no se seleccionó sucursal, obtenemos la sucursal con más existencia
    $sucursal = isset($_GET['inventa']) ? $_GET['inventa'] : '';

    // Si no se ha seleccionado sucursal, obtenemos la de mayor inventario
    if (empty($sucursal)) {
        // Si la sucursal con mayor inventario existe, la asignamos
        if ($selected_sucursal) {
            $sucursal = $selected_sucursal['inv_id'];
        }
    }

    // Validación del stock
    $cantidad = isset($_GET['cant']) ? intval($_GET['cant']) : 0;
    if ($cantidad > $selected_sucursal['inv_existencia']) {
        $message = "<div class='alert alert-danger'>La cantidad solicitada supera el stock disponible. Solo hay " . $selected_sucursal['inv_existencia'] . " unidades disponibles.</div>";
    }

    // Si el usuario no está logueado, mostrar mensaje
    elseif (empty($_SESSION["usu_id"])) {
        $message = "<div class='alert alert-danger'>Para comprar productos, debe de iniciar sesión</div>";
        $message .= "<div class='alert alert-danger'>¡Si no tienes cuenta, <a href='RegistroUsuario.html'>regístrate aquí!</a></div>";
    } elseif (empty($sucursal)) {
        // Si no se selecciona una sucursal o no se encuentra la sucursal con mayor cantidad
        $message = "<div class='alert alert-danger'>Escoge una sucursal.</div>";
    } else {
        // Si todo está correcto, agregar al carrito
        include 'carritoGuarda.php';
        $message = "<div class='alert alert-success'>Producto agregado al carrito.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="img/logo rm ck.png" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-shopping-cart"></i> <span>1</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            <!-- <div class="header__top__right__language">
                <img src="img/language.png" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">Spanis</a></li>
                    <li><a href="#">English</a></li>
                </ul>
            </div> -->
            <div class="header__top__right__auth">
                <a href="controlador_cerrars2.php"><i class="fa fa-user"></i>
                    <?php
                    if (empty($_SESSION["usu_id"])) {
                        echo "Iniciar Sesion";
                    } else {
                        echo "Cerrar Sesion";
                    }
                    ?>
                </a>
            </div>
        </div>

        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i>
                    <?php
                    if (empty($_SESSION["usu_id"])) {
                        echo " ";
                    } else {
                        echo $_SESSION["usu_email"];
                    }
                    ?>
                </li>
                <li>Envios a toda la Republica Mexicana</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php
    include "../../menus/menuFront.php";
    ?>
    <!-- Header Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/chalecosVest.png">

    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="<?php echo htmlspecialchars($product['pro_imagen']); ?>" alt="">
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo htmlspecialchars($product['pro_Producto']); ?></h3>

                        <div class="product__details__price">$<?php echo number_format($product['pro_precioIVA'], 2); ?></div>

                        <p><?php echo htmlspecialchars($product['pro_decripcion']); ?></p>

                        <!--fORMULARIO DE CARRITO-->
                        <div>
                        <div>
                        <form action="shop-details.php" method="GET">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['pro_id']); ?>">

                <!-- Sucursal seleccionada automáticamente, no visible para el usuario -->
                <?php if ($selected_sucursal) { ?>
                    <input type="hidden" name="inventa" value="<?php echo $selected_sucursal['inv_id']; ?>">
                <?php } ?>

                <h3>Cantidad</h3>
                <div class="product__details__quantity">
                    <div class="quantity">
                        <input type="number" id="cant" name="cant" min="1" value="0" max="<?php echo $selected_sucursal['inv_existencia']; ?>" required>
                    </div>
                </div>

                <br>
                <p id="_in_clave">Cantidad en existencia: <?php echo $selected_sucursal['inv_existencia']; ?></p>

                <input type="hidden" id="cliente" name="cliente" value="<?php echo $usuario_id; ?>">
                <input type="hidden" id="accion" name="accion" value="insCarrito">

                <br>

                <button id="agregar" name="agregar" class="primary-btn" type="submit">Agregar al Carrito</button>
            </form>

                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-12">
                    
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Footer Section Begin -->
    <?php
    include "../../menus/footer.html";
    ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>


</body>

</html>