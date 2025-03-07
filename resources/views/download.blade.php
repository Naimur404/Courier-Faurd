<!-- resources/views/download.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Download Our App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .download-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            max-width: 800px;
            margin: 50px auto;
        }
        
        .card-header {
            background: linear-gradient(135deg, #6f42c1, #007bff);
            color: white;
            padding: 20px;
            border-bottom: none;
        }
        
        .app-icon {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }
        
        .download-btn {
            background: linear-gradient(135deg, #6f42c1, #007bff);
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #8250df, #0d6efd);
        }
        
        .counter-box {
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 15px 25px;
            display: inline-block;
            margin-top: 20px;
            min-height: 120px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s ease;
        }
        
        .counter-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .download-count {
            font-size: 2rem;
            font-weight: bold;
            color: #6f42c1;
        }
        
        .last-download-time {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }
        
        .qr-card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            max-width: 200px;
            margin: 0 auto;
        }
        
        .qr-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        
        .features {
            margin-top: 30px;
        }
        
        .feature-item {
            margin-bottom: 15px;
        }
        
        .feature-icon {
            color: #6f42c1;
            margin-right: 10px;
        }

        .home-button-container {
            display: flex;
            justify-content: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        
        .home-button {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.9);
            color: #6f42c1;
            padding: 8px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .home-button:hover {
            background: #6f42c1;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Add loading spinner styles */
        .spinner-border {
            display: none;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="home-button-container">
        <a href="https://courier-fraud.laravel.cloud" class="home-button">
          <i class="fas fa-home"></i>
          <span>হোম পেজ</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="card download-card">
            <div class="card-header text-center">
                <h2 class="mb-0">Download Our Mobile App</h2>
            </div>
            <div class="card-body text-center p-5">
                <img src="{{asset('assets/banner.jpg')}}" alt="App Icon" class="app-icon">
                <!-- If you don't have an app icon, you can use a placeholder or remove this line -->
                
                <h3 class="mb-3">Our Amazing App</h3>
                <p class="lead mb-4">Experience the best features and functionality with our mobile application. Download now and join our growing community!</p>
                
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="counter-box mb-4">
                            <div><span class="download-count">{{ number_format($downloadCount) }}</span></div>
                            <div>Total Downloads</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="counter-box mb-4">
                            <div>Last Download</div>
                            <div class="last-download-time">{{ $lastDownloadTime ?? 'No downloads yet' }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="row align-items-center justify-content-center my-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <button id="downloadBtn" class="btn btn-primary download-btn">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <i class="fas fa-download me-2"></i> Download APK
                        </button>
                    </div>
                    <div class="col-md-6">
                        <div class="qr-code-container">
                            <div class="card p-3 qr-card">
                                <!-- Update the QR code to point to the download intent endpoint -->
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('track.download.intent')) }}" 
                                     alt="QR Code for Download" class="img-fluid">
                                <div class="mt-2 small text-muted">Scan to download</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="features text-start">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="feature-item">
                                <i class="fas fa-bolt feature-icon"></i>
                                <span>Fast and responsive</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-lock feature-icon"></i>
                                <span>Secure and reliable</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <i class="fas fa-battery-full feature-icon"></i>
                                <span>Battery efficient</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-sync feature-icon"></i>
                                <span>Regular updates</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 text-muted">
                    <small>Version 1.0.0 | Last updated: {{ date('F j, Y') }}</small>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Add the AJAX download script -->
    <script>
        document.getElementById('downloadBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Show loading spinner
            const spinner = this.querySelector('.spinner-border');
            spinner.style.display = 'inline-block';
            this.disabled = true;
            
            // First, track the intent
            fetch('{{ route("track.download.intent") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Then initiate the actual download with the tracking ID
                    window.location.href = '{{ route("download.apk") }}?track_id=' + data.track_id;
                    
                    // Reset button after a short delay
                    setTimeout(() => {
                        spinner.style.display = 'none';
                        this.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Reset button on error
                spinner.style.display = 'none';
                this.disabled = false;
            });
        });
    </script>
</body>
</html>