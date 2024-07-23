<footer class="footer">

    <div class="box-container">

      <div class="footer-item">
        <!-- Logo --> 
        <a class="logo" href="index.php">
          
          <div class="logo-name">
            <h3>ZOO <br>ARCADIA</h3>
          </div>
        </a>
       
      </div>

      <div class="footer-item">

      <div class="footer-item">
        <h2>Nos horaires</h2>
        <div class="info links">
        <?php foreach ($schedules as $schedule): ?>
          <p><?php echo htmlspecialchars($schedule['jour']); ?> <?php echo htmlspecialchars($schedule['heureOuverture']); ?> - <?php echo htmlspecialchars($schedule['heureFermeture']); ?></p>
        <?php endforeach; ?>
        </div>
      </div> 

      <div class='footer-item'>
        <h2>Adresse</h2> 
        <div class="info connect">
          
         
          <p><i class="fas fa-map"></i><span>situé en France près de la forêt de Brocéliande, en bretagne</span></p>
        </div>
      </div>

    </div>



  </footer>