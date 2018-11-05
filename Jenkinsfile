pipeline {
    agent {
        docker {
            image 'php:7.2'
        }
    }

    stages {
        stage('Build') {
            steps {
                sh 'make'
            }
        }
        stage('Package') {
            steps {
                sh 'make appstore'
            }
        }
    }
}