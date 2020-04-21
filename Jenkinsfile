pipeline {
  agent any
  stages {
    stage('test1') {
      environment {
        Stage = 'Stage'
      }
      steps {
        sh 'echo "step1"'
      }
    }

  }
  environment {
    Stage = 'Stage'
    Dev = 'Dev'
  }
}