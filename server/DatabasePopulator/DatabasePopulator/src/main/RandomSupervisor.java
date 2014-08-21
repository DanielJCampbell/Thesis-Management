package main;

public class RandomSupervisor {
	
	int supid = 0;
	String supfname = "";
	String suplname = "";
	String supPercent = "";
	

	public RandomSupervisor(int i) {
		RandomPercent rp = new RandomPercent();

		supid = 80000000 + i;
		supPercent = rp.max;

		RandomName supervisor = new RandomName();
		supfname = supervisor.first;
		suplname = supervisor.last;
	}
}