pipeline {
  agent any
  stages {
    stage('Step1') {
      environment {
        Stage = 'Stage'
      }
      steps {
        sh '''echo $USER_CREDENTIALS_USR
echo $USER_CREDENTIALS_PSW



'''
        sleep 2
      }
    }

    stage('Confirm') {
      steps {
        input(message: 'Are you sure?', id: 'deploy-step', ok: 'Proceed')
      }
    }

    stage('Step2') {
      parallel {
        stage('Step2a') {
          steps {
            sh 'echo "step2a"'
          }
        }

        stage('step2b') {
          steps {
            sh 'echo "step2b"'
          }
        }

      }
    }

  }
  environment {
    USER_CREDENTIALS = 'credentials(\'rickey-local-test-creds\')'
  }
}