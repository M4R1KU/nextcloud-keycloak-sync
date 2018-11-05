pipeline {
    agent {
        docker {
            image 'composer:1.7'
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

            post {
                success {
                    archiveArtifacts 'build/artifacts/*.tar.gz'
                }
            }
        }
    }
}