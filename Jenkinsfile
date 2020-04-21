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
        input(message: 'Are you sure?', id: 'deploy', ok: 'OK')
      }
    }

    stage('Step2') {
      steps {
        sh 'echo "step2"'
      }
    }

  }
  environment {
    Stage = 'Stage'
    Dev = 'Dev'
  }
}