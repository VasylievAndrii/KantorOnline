<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Waluty</title>
  <link rel="stylesheet" href="styles/styles.css" />
  <link rel="stylesheet" href="styles/currencies.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
  <?php include('samples/header.php'); ?>

  <main class="main">
    <section class="main--kursy_fiat">   
      <h1 class="main__heading">Kursy walut</h1>
      <div id="kursyFiatTable"></div>
    </section>
  </main>

  <?php include('samples/footer.php'); ?>
  <script src="scripts/script.js"></script>
  <script src="scripts/currencies.js"></script>
</body>
</html>