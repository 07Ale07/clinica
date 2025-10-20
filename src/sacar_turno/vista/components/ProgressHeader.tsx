import type React from "react"
import { View, Text, StyleSheet } from "react-native"
import { SafeAreaView } from "react-native-safe-area-context"

interface ProgressHeaderProps {
  currentStep: number
  totalSteps: number
  stepTitle: string
}

const ProgressHeader: React.FC<ProgressHeaderProps> = ({ currentStep, totalSteps, stepTitle }) => {
  return (
    <SafeAreaView edges={['top']}>
      <View style={styles.container}>
        <View style={styles.progressBarContainer}>
          {Array.from({ length: totalSteps }).map((_, index) => (
            <View
              key={index}
              style={[
                styles.progressStep,
                index < currentStep ? styles.progressStepCompleted : styles.progressStepPending,
              ]}
            />
          ))}
        </View>
        <Text style={styles.stepTitle}>{stepTitle}</Text>
        <Text style={styles.stepCounter}>
          Paso {currentStep} de {totalSteps}
        </Text>
      </View>
    </SafeAreaView>
  )
}

const styles = StyleSheet.create({
  container: {
    backgroundColor: "#FFFFFF",
    paddingVertical: 16,
    paddingHorizontal: 20,
    borderBottomWidth: 1,
    borderBottomColor: "#E2E8F0",
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.05,
    shadowRadius: 4,
    elevation: 2,
  },
  progressBarContainer: {
    flexDirection: "row",
    gap: 8,
    marginBottom: 12,
  },
  progressStep: {
    flex: 1,
    height: 4,
    borderRadius: 2,
  },
  progressStepCompleted: {
    backgroundColor: "#10B981",
  },
  progressStepPending: {
    backgroundColor: "#E2E8F0",
  },
  stepTitle: {
    fontSize: 18,
    fontWeight: "600",
    color: "#1E293B",
    marginBottom: 4,
  },
  stepCounter: {
    fontSize: 14,
    color: "#64748B",
  },
})

export default ProgressHeader