<style>
    body{
        height: 100%;
    }

    main{
        width: 80%;
        margin-top: 0;
    }

    h2{
        padding: 40px;
        text-align: center;
        margin-top: 5%;
    }

    h3{
        text-align: center;
    }

   /*.wrapper{
        width: 100%;
        padding-top: 50px;
    }
    .col_3{
        margin-top: 20%;
        width: 33.3333333%;
        float: left;
        min-height: 1px;
        float: center;
        text-align: center;
    }*/

    #submit_button{
        background-color: #643d9c; 
        color: #FFF; 
        font-weight: bold; 
        font-size: 20; 
        border-radius: 15px;
        text-align: center;
        cursor: pointer;
    }

    

    #valg{
        width: 100%;
        margin-top: 2%;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-gap: 30px;

    }

    #grid-admin{
        width: 100%;
        margin-top: 2%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 30px;

    }



    @media (max-width: 800px) {
        #valg{
            grid-template-columns: 1fr 1fr;
        }
        
    }

</style>