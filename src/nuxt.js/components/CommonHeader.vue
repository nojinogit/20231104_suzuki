<template>
  <header>
    <img src="@/assets/image/logo.png" alt="logo" class="logo">
    <div class="nav">
      <nav>
        <ul class="menu-group">
          <li class="menu-item">
            <NuxtLink to="/Register">新規登録</NuxtLink>
          </li>
          <li class="menu-item">
            <NuxtLink to="/Index">ログイン</NuxtLink>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<style scoped>
header {
  display: flex;
  height: 100px;
  padding: 0 50px;
  margin-bottom: 30px;
  align-items: center;
}
.logo{
  width:200px;
}
.nav {
  margin: 0 0 0 auto;
}
.menu-item {
  list-style: none;
  display: inline-block;
  padding: 10px;
}
.menu-item a {
  color: white;
  text-decoration: none;
  cursor: pointer;
}
</style>
