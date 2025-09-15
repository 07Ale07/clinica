import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet, Animated } from 'react-native';
import { Ionicons } from '@expo/vector-icons';

interface MenuOption {
  name: string;
  icon: keyof typeof Ionicons.glyphMap;
}

interface MenuProps {
  options: MenuOption[];
  onSelect: (index: number) => void;
  selectedIndex: number;
}

const Menu: React.FC<MenuProps> = ({ options, onSelect, selectedIndex }) => {
  const animatedValue = React.useRef(new Animated.Value(0)).current;

  React.useEffect(() => {
    Animated.spring(animatedValue, {
      toValue: selectedIndex,
      useNativeDriver: true,
      friction: 8,
      tension: 100,
    }).start();
  }, [selectedIndex]);

  const itemWidth = 100 / options.length;
  const translateX = animatedValue.interpolate({
    inputRange: options.map((_, i) => i),
    outputRange: options.map((_, i) => i * (100 / options.length)),
  });

  return (
    <View style={styles.container}>
      <Animated.View
        style={[
          styles.indicator,
          {
            width: `${itemWidth}%`,
            transform: [{ translateX: translateX.interpolate({
              inputRange: [0, options.length - 1],
              outputRange: ['0%', `${(options.length - 1) * 100 / options.length}%`],
            }) }],
          },
        ]}
      />

      {options.map((item, index) => (
        <TouchableOpacity
          key={index}
          style={styles.item}
          onPress={() => onSelect(index)}
        >
          <Ionicons
            name={item.icon}
            size={24}
            color={selectedIndex === index ? '#007bff' : '#6A7A8A'}
          />
          <Text
            style={[
              styles.text,
              { color: selectedIndex === index ? '#007bff' : '#6A7A8A' },
            ]}
          >
            {item.name}
          </Text>
        </TouchableOpacity>
      ))}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flexDirection: 'row',
    backgroundColor: '#FFFFFF',
    borderTopWidth: 1,
    borderTopColor: '#EBEBEB',
    paddingVertical: 10,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: -4 },
    shadowOpacity: 0.05,
    shadowRadius: 5,
    elevation: 10,
  },
  item: {
    flex: 1,
    // Estas dos líneas centran el contenido del ítem
    justifyContent: 'center', 
    alignItems: 'center',
  },
  text: {
    fontSize: 12,
    fontWeight: '600',
    marginTop: 4,
  },
  indicator: {
    position: 'absolute',
    height: 3,
    backgroundColor: '#007bff',
    bottom: 0,
    borderRadius: 2,
  },
});

export default Menu;