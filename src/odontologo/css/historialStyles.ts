import { StyleSheet } from 'react-native';

export const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#E6F0FA', // Light blue background matching dental theme
    paddingHorizontal: 20,
    paddingTop: 20,
  },
  searchContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#F7FAFD',
    borderRadius: 10,
    marginBottom: 20,
    paddingHorizontal: 10,
    borderWidth: 1,
    borderColor: '#D1E6F9',
    shadowColor: '#8A8F9E',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.2,
    shadowRadius: 8,
    elevation: 5,
  },
  searchIcon: {
    marginRight: 10,
  },
  searchInput: {
    flex: 1,
    height: 50,
    fontSize: 16,
    color: '#333',
  },
  list: {
    paddingBottom: 20,
  },
  patientItem: {
    backgroundColor: '#FFFFFF',
    borderRadius: 15,
    padding: 20,
    marginBottom: 15,
    shadowColor: '#8A8F9E', // Gray shadow
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.2,
    shadowRadius: 8,
    elevation: 5,
    borderLeftWidth: 4,
    borderLeftColor: '#4B9CDB', // Blue accent
    transform: [{ translateY: 0 }], // For potential animations
  },
  patientText: {
    fontSize: 18,
    fontWeight: '600',
    color: '#1B2C40', // Dark blue
    marginBottom: 5,
  },
  patientSubText: {
    fontSize: 16,
    color: '#6A7A8A', // Gray
    marginVertical: 5,
  },
  errorText: {
    color: '#D9534F', // Red for errors
    textAlign: 'center',
    fontSize: 16,
    marginTop: 20,
    fontWeight: '500',
  },
  noItemsText: {
    textAlign: 'center',
    fontSize: 16,
    color: '#6A7A8A', // Gray
    marginTop: 20,
    fontStyle: 'italic',
  },
});