pipeline {
    agent {
        docker {
            image 'm4r1ku/nextcloud-build-container:latest'
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
                    archiveArtifacts 'build/artifacts/appstore/*.tar.gz'
                }
            }
        }
    }
}