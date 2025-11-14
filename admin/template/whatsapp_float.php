<!-- whatsapp-float.php -->
<style>
#whatsapp-float {
  position: fixed;
  bottom: 25px; 
  right: 25px; 
  width: 60px;
  height: 60px;
  background-color: #25D366;
  color: white;
  border-radius: 50%;
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
  z-index: 1000;
  transition: all 0.3s ease;
  text-decoration: none;
}

#whatsapp-float i {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-48%, -52%); 
  font-size: 32px;
}

#whatsapp-float:hover {
  transform: scale(1.1);
  background-color: #1ebe57;
  color: #fff;
}
</style>

<a href="https://wa.me/6281234567890" target="_blank" id="whatsapp-float">
  <i class="bi bi-whatsapp"></i>
</a>
