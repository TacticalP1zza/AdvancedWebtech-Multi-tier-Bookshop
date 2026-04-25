class LoginForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            email: "",
            password: "",
            captchaAnswer: "",

            emailError: "",
            passwordError: "",
            captchaError: "",

            formMessage: "",
            isSubmitting: false,
            serverErrors: window.loginErrors || [],

            touched: {
                email: false,
                password: false,
                captchaAnswer: false
            }
        };

        this.handleChange = this.handleChange.bind(this);
        this.handleBlur = this.handleBlur.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.validateAllFields = this.validateAllFields.bind(this);
        this.getInputClass = this.getInputClass.bind(this);
        this.getButtonClass = this.getButtonClass.bind(this);
    }

    validateEmail(value) {
        const v = value.trim();

        if (v === "") return "Email is required.";
        if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(v)) {
            return "Please enter a valid email address.";
        }

        return "";
    }

    validatePassword(value) {
        if (value.trim() === "") return "Password is required.";
        return "";
    }

    validateCaptcha(value) {
        if (value.trim() === "") return "CAPTCHA is required.";
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

        this.setState((prev) => ({
            touched: {
                ...prev.touched,
                [name]: true
            }
        }));
    }

    validateAllFields() {
        return {
            emailError: this.validateEmail(this.state.email),
            passwordError: this.validatePassword(this.state.password),
            captchaError: this.validateCaptcha(this.state.captchaAnswer)
        };
    }

    handleSubmit(event) {
        const errors = this.validateAllFields();

        this.setState({
            ...errors,
            touched: {
                email: true,
                password: true,
                captchaAnswer: true
            }
        });

        const hasErrors = Object.values(errors).some((error) => error !== "");

        if (hasErrors) {
            event.preventDefault();
            this.setState({
                formMessage: "Please complete the required login fields."
            });
            return;
        }

        this.setState({
            isSubmitting: true,
            formMessage: ""
        });
    }

    getInputClass(name, error) {
        if (!this.state.touched[name]) return "input-field";
        if (error !== "") return "input-field input-error";
        return "input-field";
    }

    getButtonClass() {
        return "Form-Button";
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
                        <input type="text" name="fakeuser" autoComplete="username" style={{ display: "none" }} tabIndex="-1" />
                        <input type="password" name="fakepass" autoComplete="current-password" style={{ display: "none" }} tabIndex="-1" />

                        <div className="form-group">
                            <input
                                className={this.getInputClass("email", this.state.emailError)}
                                type="email"
                                name="email"
                                autoComplete="username"
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
                                className={this.getInputClass("password", this.state.passwordError)}
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

                        {this.state.touched.password && this.state.passwordError && (
                            <div className="Error-Message">{this.state.passwordError}</div>
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

                        <button
                            type="submit"
                            className={this.getButtonClass()}
                            disabled={this.state.isSubmitting}
                        >
                            {this.state.isSubmitting ? "Logging in..." : "Login"}
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