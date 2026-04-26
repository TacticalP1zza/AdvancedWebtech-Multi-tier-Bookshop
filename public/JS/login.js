/**
 * LoginForm.js
 *
 * Purpose:
 * - Handles client-side login form validation using React.
 * - Submits valid login requests to AuthenticationController::handleLogin().
 *
 * Design:
 * - Uses controlled React inputs.
 * - Uses onBlur validation to avoid excessive validation while typing.
 *
 * Security:
 * - Client-side validation improves usability only.
 * - Final validation is still performed server-side in AuthenticationController.
 * - CAPTCHA is displayed client-side but validated server-side.
 */

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
    }

    validateEmail(emailValue) {
        const email = emailValue.trim();

        if (email === "") {
            return "Email is required.";
        }

        if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email)) {
            return "Please enter a valid email address.";
        }

        return "";
    }

    validatePassword(passwordValue) {
        if (passwordValue.trim() === "") {
            return "Password is required.";
        }

        return "";
    }

    validateCaptcha(captchaValue) {
        if (captchaValue.trim() === "") {
            return "CAPTCHA is required.";
        }

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
        const fieldName = event.target.name;

        this.setState((previousState) => ({
            touched: {
                ...previousState.touched,
                [fieldName]: true
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
        const validationErrors = this.validateAllFields();

        this.setState({
            ...validationErrors,
            touched: {
                email: true,
                password: true,
                captchaAnswer: true
            }
        });

        const hasErrors = Object.values(validationErrors).some((errorMessage) => {
            return errorMessage !== "";
        });

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

    getInputClass(fieldName, errorMessage) {
        if (!this.state.touched[fieldName]) {
            return "input-field";
        }

        if (errorMessage !== "") {
            return "input-field input-error";
        }

        return "input-field";
    }

    renderServerErrors() {
        if (this.state.serverErrors.length === 0) {
            return null;
        }

        return (
            <div className="Error-Message">
                {this.state.serverErrors.map((errorMessage, index) => (
                    <div key={index}>{errorMessage}</div>
                ))}
            </div>
        );
    }

    render() {
        return (
            <div className="container">
                <div className="Login-container">
                    <h1 className="header">Login Form</h1>

                    {this.renderServerErrors()}

                    <form
                        method="POST"
                        action="index.php?action=handleLogin"
                        onSubmit={this.handleSubmit}
                        autoComplete="off"
                    >
                        <input
                            type="text"
                            name="fakeuser"
                            autoComplete="username"
                            style={{ display: "none" }}
                            tabIndex="-1"
                        />

                        <input
                            type="password"
                            name="fakepass"
                            autoComplete="current-password"
                            style={{ display: "none" }}
                            tabIndex="-1"
                        />

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
                                    src={"Public/Images/CaptchaImages/" + window.loginCaptchaImage}
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
                            className="Form-Button"
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