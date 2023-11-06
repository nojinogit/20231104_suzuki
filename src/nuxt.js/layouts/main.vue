<template>
  <div class="layout">
    <Sidebar class="sidebar"/>
    <Nuxt class="main"/>
  </div>
</template>

<style scoped>
.layout{
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: black;
  display:flex;
}
.sidebar{
  width:20%;
  border-right:1px solid white;
}
.main{
  width:80%;
}
</style>

