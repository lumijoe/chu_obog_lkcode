<?php

/**
 * フッター
 */
?>

</main> <!-- END .main -->
<footer>
    フッター
</footer>
<a href="#" id="pageTop"></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById("loginBtn").addEventListener("click", function() {
        // メールアドレスとパスワードの値を取得
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;

        // 認証成功条件（追加したメールアドレス）
        const validEmails = [
            "lumikojo@ikkosha.co.jp",
            "k_minamimoto@ikkosha.co.jp",
            "take_iwata@ikkosha.co.jp",
            "tanigake@ikkosha.co.jp"
        ];

        // パスワードが一致し、かつメールアドレスがリストに含まれている場合
        if (validEmails.includes(email) && password === "1922") {
            // 認証成功 → archive.html に遷移
            window.location.href = "archive.html";
        } else {
            // 認証失敗 → エラーメッセージを表示
            alert("メールアドレスまたはパスワードが間違っています。");
        }
    });
</script>

<?php wp_footer(); ?>
</body>

</html>