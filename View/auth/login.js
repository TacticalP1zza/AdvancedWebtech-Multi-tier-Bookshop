/*
/ fix error, check all naming follow naming guidelines, add invis uninvis button to password /peak feature
/ make states only update when unselecting boxes
/ add sanity elements htmlentities
*/

class LoginForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            email: "",
            password: "",

            emailError: "",
            passwordErorr: "",

            formMessage: "",
            serverErrors: window.loginErrors || [],

            touched: {
                email: false,
                password: false,
                captchaAnswer: false
            },

            captchaAnswer: "",
            captchaError: ""
        };

        this.handleChange = this.handleChange.bind(this);
        this.handleBlur = this.handleBlur.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.runValidation = this.runValidation.bind(this);
        this.getInputClass = this.getInputClass.bind(this);
        this.getButtonClass = this.getButtonClass.bind(this);
    }

    validateEmail(value) {
        if (value.trim() === "") return "Email is required";
        if (!/^[\w.-]+@([\w-]+\.)+[\w-]{2,}$/.test(value)) return "Invalid email";
        return "";
    }

    validatePassword(value) {
        if (value.trim() === "") return "Password is required";
        return "";
    }

    validateCaptcha(value) {
        if (value.trim() === "") return "CAPTCHA is required";
        return "";
    }

    handleChange(event) {
        const { name, value } = event.target;

        this.setState({
            [name]: value,
            formMessage: "",
            serverErrors: []
        });
    }

    handleBlur(event) {
        const name = event.target.name;

        this.setState(
            (prev) => ({
                touched: {
                    ...prev.touched,
                    [name]: true
                }
            }),
            () => this.runValidation(name)
        );
    }

    runValidation(name) {
        const value = this.state[name];

        if (name === "email") {
            this.setState({ emailError: this.validateEmail(value) });
        }

        if (name === "password") {
            this.setState({ passwordErorr: this.validatePassword(value) });
        }

        if (name === "captchaAnswer") {
            this.setState({ captchaError: this.validateCaptcha(value) });
        }
    }

    handleSubmit(event) {
        const emailError = this.validateEmail(this.state.email);
        const passwordErorr = this.validatePassword(this.state.password);
        const captchaError = this.validateCaptcha(this.state.captchaAnswer);


        this.setState({
            emailError: emailError,
            passwordErorr: passwordErorr,
            captchaError: captchaError,
            touched: {
                email: true,
                password: true,
                captchaAnswer: true
            }
        });

        if (emailError !== "" || passwordErorr !== "" || captchaError !== "") {
            event.preventDefault();
            this.setState({ formMessage: "Fix errors before logging in" });
        }
    }

    getInputClass(name, error) {
        if (!this.state.touched[name]) return "input-field";
        if (error !== "") return "input-field input-error";
        return "input-field input-valid";
    }

    getButtonClass() {
        const hasErrors =
        this.state.emailError !== "" ||
        this.state.passwordErorr !== "" ||
        this.state.captchaError !== "";

       const allTouched =
        this.state.touched.email &&
        this.state.touched.password &&
        this.state.touched.captchaAnswer;

        return allTouched && !hasErrors
            ? "Form-Button button-success"
            : "Form-Button button-error";
    }

    render() {
        return (
            <div className="container">
                <div className="Login-container">
                    <h1 className="header">Login Form</h1>

                    {this.state.serverErrors.length > 0 && (
                        <div className="Error-Message">
                            {this.state.serverErrors.map((error, index) => (
                                <div key={index}>{error}</div>
                            ))}
                        </div>
                    )}

                    <form
                        method="POST"
                        action="index.php?action=loginSubmit"
                        onSubmit={this.handleSubmit}
                        autoComplete="off"
                    >
                        <div className="form-group">
                            <input
                                className={this.getInputClass("email", this.state.emailError)}
                                type="email"
                                name="email"
                                autoComplete="off"
                                value={this.state.email}
                                onChange={this.handleChange}
                                onBlur={this.handleBlur}
                                placeholder=" "
                                required
                            />
                            <label className="floating-label">Email</label>
                        </div>
                        {this.state.touched.email && this.state.emailError && (
                            <div className="Error-Message">{this.state.emailError}</div>
                        )}

                        <div className="form-group">
                            <input
                                className={this.getInputClass("password", this.state.passwordErorr)}
                                type="password"
                                name="password"
                                autoComplete="current-password"
                                value={this.state.password}
                                onChange={this.handleChange}
                                onBlur={this.handleBlur}
                                placeholder=" "
                                required
                            />
                            <label className="floating-label">Password</label>
                        </div>
                        {this.state.touched.password && this.state.passwordErorr && (
                            <div className="Error-Message">{this.state.passwordErorr}</div>
                        )}
                        <div className="captcha-box">
                                {window.loginCaptchaImage && (
                                    <img
                                        className="captcha-image"
                                        src={"View/auth/CaptchaImages/" + window.loginCaptchaImage}
                                        alt="CAPTCHA verification"
                                    />
                                )}
                            </div>

                            <div className="form-group">
                                <input
                                    className={this.getInputClass("captchaAnswer", this.state.captchaError)}
                                    type="text"
                                    name="captchaAnswer"
                                    autoComplete="off"
                                    value={this.state.captchaAnswer}
                                    onChange={this.handleChange}
                                    onBlur={this.handleBlur}
                                    placeholder=" "
                                    required
                                />
                                <label className="floating-label">Enter CAPTCHA</label>
                            </div>


                            

                            {this.state.touched.captchaAnswer && this.state.captchaError && (
                                <div className="Error-Message">{this.state.captchaError}</div>
                            )}
                        <button type="submit" className={this.getButtonClass()}>
                            Login
                        </button>

                        {this.state.formMessage && (
                            <div className="Error-Message">{this.state.formMessage}</div>
                        )}
                    </form>
                </div>
            </div>
        );
    }
}

ReactDOM.render(
    <LoginForm />,
    document.getElementById("login-root")
);