<script src="login.js"></script>
<script>
    if (sessionStorage.getItem("loggedIn") !== "true") {
        alert("ログインしてください");
        window.location.href = "<?php echo home_url('/'); ?>";
    }
</script>