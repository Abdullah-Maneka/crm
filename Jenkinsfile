pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

            
        stage('Check Docker Compose Version') {
            steps {
                script {
                    // Run docker-compose --version command
                    def dockerComposeVersion = sh(script: 'docker-compose --version', returnStdout: true).trim()
                    echo "Docker Compose Version: ${dockerComposeVersion}"
                }
            }
        }
    

        stage('Run Docker Compose') {
            steps {
                script {
                    sh 'docker-compose up -d'
                }
            }
        }

        stage('Run Tests') {
            steps {
                script {
                    // Add commands to run your tests, e.g., PHPUnit for PHP
                    // Example: sh 'docker exec your-php-app-container phpunit'
                    sh 'docker exec crm-app-container phpunit'
                }
            }
        }

        //stage('Deploy') {
            //steps {
                //script {
                    // Add deployment steps if needed
                    // Example: kubectl apply -f your-deployment.yaml
                    // Deploy the application using the existing Docker Compose file
                    //sh 'docker-compose up -d'
                    
                //}
            //}
        //}
    }

    post {
    always {
        // Cleanup steps, e.g., stopping and removing containers
        script {
            sh 'docker-compose down'
        }
    }

    //success {
        // Start Docker services after successful pipeline execution
        //script {
            //sh 'docker-compose up -d'
        //}
    //}
    }

}
