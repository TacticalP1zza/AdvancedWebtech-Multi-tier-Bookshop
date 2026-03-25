class RegistrationForm extends React.Component{
    constructor(props){
        super(props)


    this.state ={
        userName: "",
        phone:"",
        email: "",
        confirmEmail: "",
        password: "",
        confirmPassword: "",

        userNameError: "",
        phoneErorr:"",
        emailErorr: "",
        confirmEmailError: "",
        passwordErorr: "",
        confirmPasswordError: "",

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

    //to do validate first number is 07
    validatePhone(value){
        if(value.trim()=== "") {
            return "phone empty";
        }
        if (!/^[0-9\s]+$/.test(value)){
            return "Phone Number Must contain numbers only";
        }
        if (value.length !==10){
            return "Phone number must be exactly 10 digits";
        }
        return "";
    }

    validateEmail(value){
        if(value.trim()=== "") {
            return "Email is Requred";
        }
        if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}+$/.test(value)){
            return "Must be valid email";
        }
        return "";
    }
    //add confimration statement
    ConfirmEmail(value){
        if(value.trim()=== "") {
            return "Must Confirm Email";
        }
        if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}+$/.test(value)){
            return "Must be valid email";
        }
        return "";
    }
    // https://ihateregex.io/expr/password/
    //Minimum eight characters, at least one upper case English letter, one lower case English letter, one number and one special character
    validatePassword(value){
        if(value.trim()=== "") {
            return "Password is Required";
        }
        if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/.test(value)){
            return "Must contain a minimum of eight characters, at least one upper case English letter, one lower case English letter, one number and one special character";
        }
        return "";
    }
    //todo add confirmation condition
    ConfirmPassword(value){
        if(value.trim()=== "") {
            return "Must confirm Password";
        }
        if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/.test(value)){
            return "Must contain a minimum of eight characters, at least one upper case English letter, one lower case English letter, one number and one special character";
        }
        return "";
    }

    handleChange(event){
        const name = event.target.name;
        const value = event.target.value;

        this.setState({[name]: value});

        if(name === "userName"){
            this.setState({userNameError: this.validateUserName(value)})
            userNameAvailability: ""
        }
        if( name === "phone"){
            this.setState({phoneErorr: this.validatePhone(value)})
        }
        if( name === "email"){
            this.setState({emailErorr: this.validateEmail(value)})
        }
        if( name === "password"){
            this.setState({passwordErorr: this.validatePassword(value)})
        }
        /*if( name === ""){
            this.setState({:this.validate(value)})
        }*/
    }

    checkUserNameAvailability(){
        const userNameError = this.validateUserName(this.state.userName)

        this.setState({ userNameError: userNameError})

        if(userNameError !==""){
            return;
        }

        fetch("index.php?checkUserName=" + encodeURIComponent(this.state.email))
        .then(response => response.json)
        .then(data =>{
            if (data.exists){
                this.setState({userNameAvailability: "Username is already in use"})

            } else { this.setState({userNameAvailability: "Username is available"})}
        })
        .catch(error => {
            this.setState({userNameAvailability: "could not check username right now"})
        });
    }

    handleSubmit(event){
        const userNameError = this.validateUserName(this.state.userName);
        const phoneErorr = this.validatePhone(this.state.phone)
        const emailErorr= this.validateEmail(this.state.email)
        const passwordErorr= this.validatePassword(this.state.password)
        
        this.setState({
           userNameError: userNameError,
           phoneErorr:  phoneErorr,
           emailErorr: emailErorr,
           passwordErorr: passwordErorr
        })


        if(
            userNameError !=="" ||
            phoneErorr !=="" ||
            emailErorr !=="" ||
            passwordErorr !=="" ||
            this.state.checkUserNameAvailability === "Username is already in use"
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
                <label>Username</label><br />
                <input
                    type = "text"
                    name = "userName"
                    value ={this.state.userName}
                    onChange ={this.handleChange}
                />
                <div style={{color:"red"}}>{this.state.userNameError}</div>
                </div>

                <div className ="form-group">
                <label>Username</label><br />
                <input
                    type = "text"
                    name = "phone"
                    value ={this.state.phone}
                    onChange ={this.handleChange}
                />
                <div style={{color:"red"}}>{this.state.phoneErorr}</div>
                </div>
                
                <div className ="form-group">
                <label>Username</label><br />
                <input
                    type = "text"
                    name = "email"
                    value ={this.state.email}
                    onChange ={this.handleChange}
                />
                <div style={{color:"red"}}>{this.state.emailErorr}</div>
                </div>

                <div className ="form-group">
                <label>Username</label><br />
                <input
                    type = "text"
                    name = "password"
                    value ={this.state.password}
                    onChange ={this.handleChange}
                />
                <div style={{color:"red"}}>{this.state.passwordErorr}</div>
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
