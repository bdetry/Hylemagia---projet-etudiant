<script type="text/javascript">
    
    function redirectVerif()
    {
        window.location.href = "index.php?c=game";
    }
    
    var body = document.body;
    console.log(body);
    
    body.addEventListener('load' , setTimeout(redirectVerif , 5000) , false);
    
</script>
