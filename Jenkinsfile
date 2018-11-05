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
            	configFileProvider(
            		[configFile(fileId: '28374639-ee7c-41ee-83c6-7eef5c8cb608', variable: 'CERT')]) {
                	sh 'make appstore'
            	}
            }

            post {
                success {
                    archiveArtifacts 'build/artifacts/appstore/*.tar.gz'
                    archiveArtifacts 'build/artifacts/signature/*'
                }
            }
        }
    }
}