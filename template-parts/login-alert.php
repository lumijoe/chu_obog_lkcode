<script src="login.js"></script>
<script>
    if (sessionStorage.getItem("loggedIn") !== "true") {
        alert("ログインしてください");
        window.location.href = "https://lkcodetest.sakura.ne.jp/obogtest/";
    }
</script>