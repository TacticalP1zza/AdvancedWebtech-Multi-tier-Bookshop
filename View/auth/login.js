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
        userName: "",
        password: "",

        userNameError: "",
        passwordErorr: "",

        formMessage:""

    };
    
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);


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

    handleChange(event){
        const name = event.target.name;
        const value = event.target.value;

        this.setState({[name]: value}, () => {
        if( name === "userName"){
            this.setState({
               userNameError: this.validateUserName(value),
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
        const userNameError = this.validateUserName(this.state.userName);
        const passwordErorr= this.validatePassword(this.state.password);
        
        this.setState({
           userNameError: userNameError,
           passwordErorr: passwordErorr
        })


        if(
            userNameError !=="" ||
            passwordErorr !==""
            ){
            event.preventDefault();
            this.setState({formMessage: "please fix the errors before registering"})
        }
    }


    render(){
        return(
            <div className ="Login-container">
            <form method="POST" action="index.php?action=loginSubmit" onSubmit={this.handleSubmit}>

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
                <label>password</label><br />
                <input
                    type = "password"
                    name = "password"
                    value ={this.state.password}
                    onChange ={this.handleChange}
                />
                <div style={{color:"red"}}>{this.state.passwordErorr}</div>
                </div>

                <button type="submit">Login</button>
                <div style={{color:"red"}}>{this.state.formMessage}</div>
            </form>
            </div>
        );
    }
   

    }

ReactDOM.render(
        <LoginForm />, document.getElementById("login-root")
        )
