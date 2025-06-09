<?php
  require 'config/bbdd.php';
  require 'config/config.php';

  $db= new Database();
  $con = $db->conectar();
  $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1");
  $sql->execute();

  $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  //print_r($_SESSION);

  #session_destroy();
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
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php foreach($resultado as $row){ ?>
          <div class="col">
            <div class="card w-100 shadow-sm">
              <?php
              $id = $row['id'];
              $img= "img/" . $id . "/principal.png";

              if(!file_exists($img)){
                $img = "img/no-photo.png";
              }
              ?>
              <img src=<?php echo $img;?>>
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['nombre'];?></h5>
                <p class="card-text">$ <?php echo number_format($row['precio'],2,'.',',');?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="details.php?id=<?php echo $row['id'];?>&token=<?php echo hash_hmac('sha1',$row['id'],KEY_TOKEN);?>" class="btn btn-primary">Detalles</a>
                  </div>
                   <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1',$row['id'],KEY_TOKEN);?>')">Agregar al carrito</button>
                </div>
              </div>
            </div>
          </div>
        <?php }?>
      </div>
    </div>
  </main>
  
  <footer class="footer text-lg-start bg-primary bg-gradient mt-auto">
    <div class="container text-md-start pt-2 pb-1">
        <!-- Grid row -->
        <div class="row mt-3">
            <!-- Grid column -->
            <div class="col-12 col-lg-3 col-sm-12 mb-2">
                <!-- Content -->
                <p class="text-white h3">
                    Lyra-Tey oficial
                </p>
                <p class="mt-1 text-white">
                    &copy; 2025 - 2026 Copyright: <a href="#" target="_blank" class="text-white">Omardj tm</a>
                </p>
            </div>
            <!-- Grid column -->
        </div>
        <!-- Grid row -->
    </div>
</footer>

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