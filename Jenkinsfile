pipeline {
  agent any
  stages {
    stage('Step1') {
      environment {
        Stage = 'Stage'
      }
      steps {
        sh 'echo "step1"'
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
    Stage = 'Stage'
    Dev = 'Dev'
  }
}