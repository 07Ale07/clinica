import { StyleSheet, Platform } from 'react-native';

export const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#E6F0FA', // Light blue background for a clean look
    paddingHorizontal: 16,
    paddingTop: 24,
  },
  title: {
    fontSize: 28,
    fontWeight: '700',
    color: '#1B2C40', // Dark blue for strong contrast
    textAlign: 'left',
    marginBottom: 12,
    ...Platform.select({
      ios: {
        fontFamily: 'System',
      },
      android: {
        fontFamily: 'Roboto',
      },
    }),
  },
  subtitle: {
    fontSize: 16,
    color: '#6A7A8A', // Softer gray for secondary text
    marginBottom: 16,
    fontStyle: 'italic',
  },
  dayPicker: {
    backgroundColor: '#FFFFFF',
    borderRadius: 12,
    marginBottom: 24,
    padding: 8,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 6,
    elevation: 3, // Moderate elevation for Android
    borderWidth: 1,
    borderColor: '#E0E7FF', // Subtle border for definition
  },
  picker: {
    height: 48,
    width: '100%',
    backgroundColor: '#F8FAFC', // Light gray for picker background
    borderRadius: 8,
    color: '#1B2C40',
  },
  list: {
    paddingBottom: 32,
  },
  scheduleItem: {
    backgroundColor: '#FFFFFF',
    borderRadius: 12,
    padding: 16,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 6,
    elevation: 3, // Moderate elevation for Android
    borderLeftWidth: 4,
    borderLeftColor: '#4B9CDB', // Blue accent for visual hierarchy
  },
  scheduleText: {
    fontSize: 17,
    fontWeight: '600',
    color: '#1B2C40', // Dark blue for primary text
    marginBottom: 4,
  },
  scheduleSubText: {
    fontSize: 15,
    color: '#6A7A8A', // Gray for secondary info
    marginVertical: 4,
    lineHeight: 20, // Improved readability
  },
  editButton: {
    backgroundColor: '#4B9CDB', // Blue button
    borderRadius: 8,
    paddingVertical: 8,
    paddingHorizontal: 16,
    alignSelf: 'flex-end',
    justifyContent: 'center',
    alignItems: 'center',
    ...Platform.select({
      ios: {
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 1 },
        shadowOpacity: 0.2,
        shadowRadius: 3,
      },
      android: {
        elevation: 2,
      },
    }),
  },
  editButtonText: {
    color: '#FFFFFF',
    fontSize: 14,
    fontWeight: '600',
  },
  addButton: {
    backgroundColor: '#4B9CDB', // Blue button
    borderRadius: 12,
    paddingVertical: 12,
    paddingHorizontal: 20,
    alignItems: 'center',
    marginTop: 16,
    marginBottom: 24,
    ...Platform.select({
      ios: {
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 2 },
        shadowOpacity: 0.2,
        shadowRadius: 4,
      },
      android: {
        elevation: 3,
      },
    }),
  },
  addButtonText: {
    color: '#FFFFFF',
    fontSize: 16,
    fontWeight: '700',
  },
  loadingText: {
    textAlign: 'center',
    fontSize: 16,
    color: '#6A7A8A', // Gray for loading state
    marginTop: 24,
    fontStyle: 'italic',
  },
  errorText: {
    textAlign: 'center',
    fontSize: 16,
    color: '#D9534F', // Red for errors
    marginTop: 24,
    fontWeight: '500',
    paddingHorizontal: 16,
    lineHeight: 22, // Improved readability
  },
  noSchedulesText: {
    textAlign: 'center',
    fontSize: 16,
    color: '#6A7A8A', // Gray for empty state
    marginTop: 24,
    fontStyle: 'italic',
    paddingHorizontal: 16,
    lineHeight: 22,
  },
});