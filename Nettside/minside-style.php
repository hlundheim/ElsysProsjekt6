<style>
    main{
        width: 70%;
    }

    input[type=text], input[type=password] {
        width: 50%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

        button:hover {
        opacity: 0.8;
    }

    .cancelbtn {
        width: 20%;
        padding: 10px 18px;
        background-color: #f44336;
        
    }

    .container {
        display: grid;
        grid-template-columns: 1fr;
        padding: 16px;
        justify-items: center;
    }

    span.psw {
        float: right;
        padding-top: 16px;
    }

    @media (max-width: 800px){
        .cancelbtn {
            width: 30%;
        }
        input[type=text], input[type=password] {
            width: 65%;
        }

    }
    
</style>