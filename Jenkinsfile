pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'gamarl01/sistema-caputa'
    }

    stages {
        stage('Clone Repository') {
            steps {
                git 'https://github.com/GamaRL/TSIC2_LaravelApp.git'
            }
        }
        stage('Build Docker Image') {
            steps {
                sh 'docker build -t $DOCKER_IMAGE .'
            }
        }
        stage('Push Docker Image') {
            steps {
                sh 'docker push $DOCKER_IMAGE'
            }
        }
        stage('Deploy to Kubernetes') {
            steps {
                sh '''
                kubectl apply -f deployment.yaml
                '''
            }
        }
    }
}
