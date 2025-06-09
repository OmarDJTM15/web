<?php
  require 'config/config.php';
  require 'config/bbdd.php';

  $db= new Database();
  $con = $db->conectar();

  $id = isset($_GET['id']) ? $_GET['id']:'';
  $token= isset($_GET['token']) ? $_GET['token'] : '';
  
  if($id == ''|| $token == '' ){
    echo 'ERROR AL PROCESAR LA PETICION';
    exit;

  }else{
    $token_tmp = hash_hmac('sha1', $id,KEY_TOKEN);
    if($token==$token_tmp){

      $sql = $con->prepare("SELECT count(id)FROM productos WHERE id=? AND activo = 1");
      $sql->execute([$id]);
      if($sql->fetchColumn()>0){
        $sql = $con->prepare("SELECT nombre, descrpcion, precio ,descuento FROM productos WHERE id=? AND activo = 1");
        $sql->execute([$id]);
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $nombre = $row['nombre'];
        $descrpcion = $row['descrpcion'];
        $precio = $row['precio'];
        $descuento = $row['descuento'];
        $precio_des = $precio -($precio* $descuento/100);
        $dir_img= 'img/'. $id .'/';
        $ruta_Img = $dir_img . 'principal.png';

        if(!file_exists($ruta_Img)){
          $ruta_Img = "img/no-photo.png";
        }
        $imagenes = array();
        if(file_exists($dir_img)){
        $dir=dir($dir_img);
          while(($archivo = $dir->read())!= false){
            if($archivo!= 'principal.png'&& (strpos($archivo, 'png')||strpos($archivo, 'jpg'))){
              $imagenes[]= $dir_img . $archivo;

            }
          }
          $dir->close();
      }
      }
    }else{
      echo 'Error al procesar peticion';
      exit;
    }

  }
  
?>

<html lang="es" class="h-100">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda Online</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="css/estilos.css" rel="stylesheet">
  <style>
  /* Indicadores del carrusel más oscuros */
  .carousel-indicators [data-bs-target] {
    background-color: #333;
  }

  /* Flechas visibles sobre fondo blanco */
  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    filter: invert(1) brightness(0.5);
  }

  /* Mejora accesible en pantallas oscuras */
  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    width: 2rem;
    height: 2rem;
  }
</style>

</head>

<body class="d-flex flex-column h-100">
  <!--Barra de navegación-->
  <header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a href="#" class="navbar-brand">
          <strong>Tienda Online</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarHeader">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a href="#" class="nav-link active">Catalogo</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Contacto</a>
            </li>
          </ul>
          <a href="checkout.php" class="btn btn-primary">Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $nun_cart;?></span></a>
        </div>
      </div>
    </div>
  </header>

  <!--Contenido-->
  <main>
    <div class="container">
      <div class="row">
        <div class="col-md-6 order-md-1">

          <div id="carouselImg" class="carousel slide" data-bs-ride="carousel" style="max-width: 400px; margin: auto;">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselImg" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <?php for ($i = 1; $i <= count($imagenes); $i++): ?>
              <button type="button" data-bs-target="#carouselImg" data-bs-slide-to="<?php echo $i; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
            <?php endfor; ?>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="<?php echo $ruta_Img; ?>" class="d-block w-100">
              </div>
              <?php foreach($imagenes as $img) {?>
              <div class="carousel-item">
                <img src="<?php echo $img; ?>" class="d-block w-100">
              </div>
              <?php } ?>
              </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselImg" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselImg" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <div class="col-md-6 order-md-2">
          <h2><?php echo $nombre; ?></h2>
          <?php if($descuento > 0){ ?>
            <p><del><?php echo MONEDA . number_format($precio, 2,'.',',') ?></del></p>
            <h2>
              <?php echo MONEDA . number_format($precio_des, 2,'.',','); ?>
              <small class="text-success"><?php echo $descuento; ?>% descuento </small>
            </h2>
            <?php }else{?>
          <h2><?php echo MONEDA . number_format($precio, 2,'.',','); ?></h2>
          <?php }?>
          <p class="lead">
            <?php echo $descrpcion; ?>
          </p>
          <div class="d-grid gap-3 col-10 mx-auto">
              <button class="btn btn-primary" type="button">Comprar ahora</button>
              <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
  crossorigin="anonymous"></script>

  <script>
    function addProducto(id,token){
      let url = 'clases/carrito.php'
      let formData = new FormData()
      formData.append('id',id)
      formData.append('token',token)
      
      fetch(url, {
        method:'POST',
        body: formData,
        mode: 'cors'
      }).then(response => response.json())
      .then(data =>{
        if(data.ok){
          let elemento = document.getElementById("num_cart")
          elemento.innerHTML= data.numero
        }
      })
    }
  </script>
</body>

</html>