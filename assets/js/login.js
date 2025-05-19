console.log("Username from .env:", envVars.username);
console.log("Password from .env:", envVars.password);


// セッションストレージでログイン状態を管理
function isLoggedIn() {
  return sessionStorage.getItem("loggedIn") === "true";
}
function setLoggedIn() {
  sessionStorage.setItem("loggedIn", "true");
}

// 初回ロード時、ログイン済みならフォームもオーバーレイも非表示
window.addEventListener("DOMContentLoaded", function () {
  if (isLoggedIn()) {
    document.getElementById("login-form").style.display = "none";
    document.getElementById("overlay").style.display = "none";
  }
});

// クリックでフォーム表示（何度でも→ログイン済みなら出さない）
document.addEventListener("click", function (event) {
  const loginForm = document.getElementById("login-form");
  const overlay = document.getElementById("overlay");

  if (isLoggedIn()) return; // ログイン済みなら何もしない
  if (loginForm.contains(event.target) || overlay.contains(event.target))
    return;

  loginForm.style.display = "block";
  overlay.style.display = "block";
});

// ✕ボタンクリックで非表示にする
document
  .getElementById("close-btn")
  .addEventListener("click", function (event) {
    document.getElementById("login-form").style.display = "none";
    document.getElementById("overlay").style.display = "none";
    event.stopPropagation();
  });

// オーバーレイクリックでも閉じるようにする（オプション）
document.getElementById("overlay").addEventListener("click", function () {
  document.getElementById("login-form").style.display = "none";
  document.getElementById("overlay").style.display = "none";
});

// ログインフォーム送信時にセッションストレージへ保存
// document.querySelector("#login-form form").addEventListener("submit", function (event) {
//   event.preventDefault();
//   setLoggedIn();
//   document.getElementById("login-form").style.display = "none";
//   document.getElementById("overlay").style.display = "none";
// });
// ログインフォーム送信時にenvVarsと比較して認証する
document.querySelector("#login-form form").addEventListener("submit", function (event) {
  event.preventDefault();

  const inputUsername = document.getElementById("username").value;
  const inputPassword = document.getElementById("password").value;

  if (inputUsername === envVars.username && inputPassword === envVars.password) {
    setLoggedIn();
    document.getElementById("login-form").style.display = "none";
    document.getElementById("overlay").style.display = "none";
  } else {
    alert("ユーザー名またはパスワードが正しくありません。");
  }
});


// すべてのaタグのクリックを監視し、未ログインなら遷移を止める
document.querySelectorAll('a').forEach(function(link) {
  link.addEventListener('click', function(event) {
    if (!isLoggedIn()) {
      event.preventDefault();
      alert('ログインしてください');
    }
  });
});