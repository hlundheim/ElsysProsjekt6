<style>
    main{
    width: 80%;
    margin: auto;
    text-align: center;
    margin-top: 7%;
  }
  
  body{
    margin-bottom: 50px;
    font-family: 'Tajawal', sans-serif;
    font-family: "Courier New", Courier, monospace;
    background-color: #D3B4DB;
    margin: 0;
  }
  
  .gridcontainer{
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    background-color: #846e99;
    margin-top: 0px;
    opacity: 90%;
  }
  
  nav a{
    text-decoration: none;
    color: black;
    font-size: 20px;
  }

  nav a:hover{
    color: white;
  }

  nav{
    width: 100%;
    justify-content: space-around;
    display: flex;
    padding: 15px;
  }

  h1{
    margin: 0px;
    margin-left: 100px;
    color: black;
    font-size: 20px;
    text-decoration: none;
  }

  a{
    text-decoration: none;
    color: black;
  }

  header{
      top:0;
      margin-top: 0;
      width: 100%;
      z-index: 3;
      position: fixed;
  }

  #mobil{
    width: 100%;
    background-color: #846e99;
    opacity: 90%;
    text-align: right;
    box-sizing: border-box;
    display: none;
  }

  @media (max-width: 800px){
        main{
            width: 90%;
            margin-top: 150px;
        }
        #mobil{
            display: block;
            padding: 20px;
        }

        .gridcontainer{
            width: 100%;
            display: block;
            text-align: center
        }

        nav{
            flex-direction: column;
        }
        p{
            font-size: 16px;
        }
        h1{
            margin-left: 30px;
        }
    }
</style>