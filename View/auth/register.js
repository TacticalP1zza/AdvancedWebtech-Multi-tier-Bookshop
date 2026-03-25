class RegistrationForm extends React.Component{
    constructor(props){
        super(props)


    this.state ={
        usern=Name: "",
        phone:"",
        email: "",
        password: "",

        userNameError: "",
        phoneErorr:"",
        emailErorr: "",
        passwordErorr: "",

        userNameAvailability:"",
        formMessage:""


    };
    
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.checkUserNameAvailability = this.checkUserNameAvailability.bind(this);

}

    validateUserName(value){
        if(value.trim()=== "") {
            return "Username empty";
        }
        if (!/^[A-Za-z\s]+$/.test(value)){
            return "Username Must contain Letters only";
        }
        return "";
    }

    handleChange(event){
        const userName = event.target.userName;
        const value = event.target.value;

        this.setState({
            [userName]: value
        });

        if(userName === "userName"){
            this.setState({userNameError: this.validateUserName(value)})
        }
    }

    handleSubmit(event){
        const userNameError = this.validateUserName(this.state.userName);

        this.setState({
            userNameError: userNameError
        });

        if(
            userNameError !==""
        ){
            event.preventDefault();
            this.setState({formMessage: "please fix the errors before registering"})
        }
    }


    render(){
        return(
            <div className ="registeration-container">
            <form method="POST" action="index.php?action=registerSubmit" onSubmit={this.handleSubmit}>

                <div className ="form-group">
                <label>Username</label>
                <input
                    type = "text"
                    name = "name"
                    value ={this.state.name}
                    onChange ={this.handleChange}
                />
                <div style={{color:"red"}}>{this.state.nameError}</div>
                </div>

                <button type="submit">Register</button>
                <div style={{color:"red"}}>{this.state.formMessage}</div>
            </form>
            </div>
        );
    }
   

    }

ReactDOM.render(
        <RegistrationForm />, document.getElementById("register-root")
        )
