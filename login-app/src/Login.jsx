// LoginPage.jsx
import { useState } from 'react';
import "./LoginPage.css"; // external CSS file

export default function LoginPage() {
    const [username, setUsername] = useState('');
    const [otp, setOtp] = useState('');
    const [step, setStep] = useState(1);
    const [message, setMessage] = useState('');
    const [website, setWebsite] = useState('');

    const sendOTP = async () => {
        try {
            const response = await fetch('http://localhost:8000/auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ action: 'send_otp', username, otp, website })
            });

            setStep(2);
            setMessage('OTP sent successfully');
        } catch (err) {
            setMessage('Failed to send OTP');
        }
    };

    const login = () => {
        fetch('http://localhost:8000/auth.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ action: 'validate_otp', username, otp, website })
        }).then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json(); // await here
        }).then(data => {
            console.log('✌️res data --->', data);
            if (data.status === 'ok') {
                localStorage.setItem('token', data.token); // Adjust if token is directly in response or under data
                window.location.href = `http://localhost:8000/set_token.html?token=${encodeURIComponent(data.token)}`;

                // window.location.href = 'http://localhost:8000/secure.php';
            } else {
                setMessage('Invalid OTP');
            }
        }).catch(err => {
            console.log('✌️err --->', err);
            setMessage('Login failed');
        });
    };

    return (
        <div className="login-wrapper">
            <div className="login-card">
                <h2>{step === 1 ? "Login" : "Enter OTP"}</h2>
                <input
                    type="text"
                    placeholder="Website"
                    value={website}
                    style={{ display: 'none' }}
                    onChange={e => setWebsite(e.target.value)}
                />
                {step === 1 ? (
                    <>
                        <input
                            type="text"
                            placeholder="Username"
                            value={username}
                            onChange={e => setUsername(e.target.value)}
                        />
                        <button onClick={sendOTP}>Send OTP</button>
                    </>
                ) : (
                    <>
                        <input
                            type="text"
                            placeholder="Enter OTP"
                            value={otp}
                            onChange={e => setOtp(e.target.value)}
                        />
                        <button onClick={login}>Login</button>
                    </>
                )}
                <p>{message}</p>
            </div>
        </div>
    );
}
