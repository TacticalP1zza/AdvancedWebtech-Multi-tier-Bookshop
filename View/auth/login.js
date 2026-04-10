/*
/ fix error, check all naming follow naming guidelines, add invis uninvis button to password /peak feautre
/ make states only update when unselecting boxes
/confirm email should only update after typeing its it box same with confirm password
/add sanity elements htmlentites
*/



class LoginForm extends React.Component{
    constructor(props){
        super(props)


    this.state ={
        email: "",
        password: "",

        emailError: "",
        passwordErorr: "",

        formMessage:""

    };
    
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);


}

    validateEmail(value){
        if(value.trim()=== "") {
            return "email empty";
        }
        if (!/^[\w.-]+@([\w-]+\.)+[\w-]{2,4}$/.test(value)){
            return "email Must contain Letters only";
        }
        return "";
    }


    // https://ihateregex.io/expr/password/
    //Minimum eight characters, at least one upper case English letter, one lower case English letter, one number and one special character
    validatePassword(value){
        if(value.trim()=== "") {
            return "Password is Required";
        }
        return "";
    }

    handleChange(event){
        const name = event.target.name;
        const value = event.target.value;

        this.setState({[name]: value}, () => {
        if( name === "email"){
            this.setState({
               emailError: this.validateEmail(value),
            });
        }
      
        if( name === "password"){
            this.setState({
               passwordErorr: this.validatePassword(value),
            });
        }
    });
    }


    handleSubmit(event){
        const emailError = this.validateEmail(this.state.email);
        const passwordErorr= this.validatePassword(this.state.password);
        
        this.setState({
           emailError: emailError,
           passwordErorr: passwordErorr
        })


        if(
            emailError !=="" ||
            passwordErorr !==""
            ){
            event.preventDefault();
            this.setState({formMessage: "please fix the errors before registering"})
        }
    }


    render(){
        return(
            <div className ="container">
            <div className ="Login-container">
            <h1 className = "header">Login Form</h1>
            <form method="POST" action="index.php?action=loginSubmit" onSubmit={this.handleSubmit}>

                <div className ="form-group">
                <input className="input-field"
                    type = "email"
                    name = "Email"
                    autoComplete="email"
                    value ={this.state.email}
                    onChange ={this.handleChange}
                    placeholder = "" required></input>
                    <label className="floating-label">Email</label>
                </div>
                <div  className = "Error-Message" style={{color:"red"}}>{this.state.emailError}</div>

                <div className ="form-group">
    
                <input className="input-field"
                    type = "password"
                    name = "password"
                    autoComplete="current-password"
                    value ={this.state.password}
                    onChange ={this.handleChange}
                    placeholder ="" required
                /> <label className="floating-label">Password</label>
                </div>
                <div className = "form-group" style={{color:"red"}}>{this.state.passwordErorr}</div>

                <button type="submit" className = "Form-Button">Login</button>
                <div style={{color:"red"}}>{this.state.formMessage}</div>
            </form>
            </div>
            </div>
        );
    }
   

    }

ReactDOM.render(
        <LoginForm />, document.getElementById("login-root")
        )
