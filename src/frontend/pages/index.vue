<template>
  <div>
    <div class="main-wrapper justify-center">
      <div class="top-text-wrap">
        <v-img
          :src="image_src_logo"
        />
        <v-img
          :src="subtext"
          class="top-text"
          contain
        />
        <v-img
          :src="maintext"
          contain
          width="100%"
          class="text-No1"
        />
      </div>
      <div class="btn-wrap">
        <a class="btn-text" href="/joinleave/join">無料登録して始める</a>
      </div>
      <div class="intro-wrap">
        <div class="intro-small-wrap">
          <h3 class="intro-headline">特徴I</h3>
          <p class="intro-text">完全無料 課金したくてもできません</p>
        </div>
        <div class="intro-small-wrap">
          <h3 class="intro-headline">特徴II</h3>
          <p class="intro-text">顔面を重視したマッチングアプリです</p>
        </div>
        <div class="intro-small-wrap">
          <h3 class="intro-headline">特徴III</h3>
          <p class="intro-text">顔面レベルが適した人とマッチします</p>
        </div>
        <div class="intro-small-wrap">
          <h3 class="intro-headline">特徴IV</h3>
          <p class="intro-text">自分の顔面レベルが測定できます</p>
        </div>
      </div>
      <div class="btn-wrap">
        <a class="btn-text" href="/MATCH/gender">マッチング診断を開始</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TopPage',
  data() {
    return {
      image_src_logo: require("@/../../storage/image/logo/logotouka.png"),
      subtext: require("@/assets/texts/understandMyself-touka.png"),
      maintext: require("@/assets/texts/No1-topText2.png")
    }
  },
}
</script>
<style scoped>
a {
  text-decoration: none;
}

h3 {
  font-family: 'Rampart One', cursive;
}

.main-wrapper {
  margin-top: 10%;
  padding-left: 20%;
  padding-right: 20%;
}

.top-text-wrap {
  margin-bottom: 30px;
}

.top-text {
  padding-right: 20%;
  padding-left: 20%;
}

.btn-wrap {
  text-align: center;
  margin-top: 20px;
  margin-bottom: 20px;
}

.btn-text {
  border-radius: 30px;
  background-color: #f57ab1;
  color: white;
  padding: 15px;
  display: inline-block;
  font-size: 15px;
  font-weight: bolder;
  width: 75%;
  max-width: 400px;
  min-width: 200px;
}

.intro-wrap {
  margin-top: 30px;
  margin-bottom: 30px;
  text-align: center;
}

.intro-headline {
  font-size: 17px;
  margin-top: 10%;
  margin-bottom: 10px;
  text-align: left;
  padding-left: 10%;
  color: black;

}

.intro-text {
  font-size: 12px;
  margin-top: 10%;
  color: black;
}

@media screen and (min-width: 500px) {
  .intro-text {
    font-size: 15px;
  }
}

@media screen and (min-width: 750px) {
  .main-wrapper {
    margin-top: 10%;
    padding-left: 25%;
    padding-right: 25%;
  }

  .btn-text {
    border-radius: 50px;
    padding: 20px;
    margin-top: 50px;
    display: inline-block;
    font-size: 20px;
  }

  .intro-wrap {
    margin-top: 50px;
  }

  .intro-headline {
    font-size: 30px;
  }

  .intro-text {
    font-size: 20px;
  }
}

@media screen and (min-width: 1200px) {
  .btn-text {
    border-radius: 50px;
    padding: 30px;
    margin-top: 50px;
    display: inline-block;
    font-size: 30px;
  }

  .intro-wrap {
    margin-top: 80px;
  }

  .intro-headline {
    font-size: 50px;
  }

  .intro-text {
    font-size: 30px;
  }
}
</style>
