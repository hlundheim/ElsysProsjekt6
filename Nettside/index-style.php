<style>
    body{
    height: 100%;
    }

    main{
        width: 100%;
        margin-top: 0;
    }
    
    #forside{
        height: 100%;
        width: 100%;
        border-style:outset;
        border-top: hidden;
        border-right: hidden;
        border-left: hidden;
        border-width: 7px;
        object-fit: cover;
    }

    .bildetekst{
        text-decoration: none;
        position: absolute;
        background-color: black;
        padding: 10px;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        color: black;
        z-index: 2;
        width: 15%;
        font-size: 30px;
        color: white;
        text-align: center;
    }

    @media (max-width: 800px){
        .bildetekst{
            font-size: 20px;
        }

    }



</style>